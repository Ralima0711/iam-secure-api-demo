<?php

namespace App\Application\UseCases;

use App\Domain\Contracts\AuthServiceInterface;
use App\Domain\Contracts\UserRepositoryInterface;
use App\Domain\Contracts\AuditServiceInterface;
use App\Domain\Contracts\LoginAttemptServiceInterface;

/**
 * 🔐 LoginUseCase
 *
 * Caso de Uso responsável pelo fluxo completo de autenticação.
 *
 * Princípios aplicados:
 * - Clean Architecture (Application não conhece Laravel)
 * - DIP (Dependemos apenas de contratos)
 * - Segurança contra User Enumeration
 * - Auditoria de eventos
 * - Proteção contra brute force
 *
 * Este UseCase orquestra:
 * - Controle de tentativas por IP
 * - Validação de existência de usuário
 * - Autenticação
 * - Registro estruturado de logs
 */
class LoginUseCase
{
    /**
     * Injeção de dependências via interfaces.
     *
     * AuthServiceInterface → abstrai JWT/OAuth/etc.
     * UserRepositoryInterface → abstrai acesso ao banco
     * AuditServiceInterface → abstrai mecanismo de log
     * LoginAttemptServiceInterface → abstrai controle de tentativas
     */
    public function __construct(
        private AuthServiceInterface $authService,
        private UserRepositoryInterface $userRepository,
        private AuditServiceInterface $auditService,
        private LoginAttemptServiceInterface $loginAttemptService
    ) {}

    /**
     * Executa o processo completo de autenticação.
     *
     * @param string      $email
     * @param string      $password
     * @param string|null $ip
     * @param string|null $userAgent
     *
     * @return array
     */
    public function execute(
        string $email,
        string $password,
        ?string $ip = null,
        ?string $userAgent = null
    ): array {

        /**
         * 🔑 Criamos uma chave única baseada no IP.
         * Isso permitirá controlar tentativas por origem.
         */
        $attemptKey = 'login_attempts:' . $ip;

        /**
         * 🛑 Verifica se o IP está temporariamente bloqueado.
         */
        if ($this->loginAttemptService->tooManyAttempts($attemptKey)) {

            $this->auditService->log(
                event: 'login_blocked',
                userId: null,
                ip: $ip,
                userAgent: $userAgent,
                metadata: ['reason' => 'too_many_attempts']
            );

            throw new \Exception('Muitas tentativas. Tente novamente mais tarde.');
        }

        /**
         * 🔎 Busca usuário pelo e-mail.
         */
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {

            // Incrementa tentativa
            $this->loginAttemptService->increment($attemptKey);

            // Registra tentativa falha (sem revelar existência)
            $this->auditService->log(
                event: 'login_failed',
                userId: null,
                ip: $ip,
                userAgent: $userAgent,
                metadata: [
                    'reason' => 'user_not_found'
                ]
            );

            throw new \Exception('Credenciais inválidas');
        }

        try {

            /**
             * 🔐 Delegamos autenticação ao AuthService.
             */
            $token = $this->authService->attempt($email, $password);

            /**
             * ✅ Resetamos contador após sucesso.
             */
            $this->loginAttemptService->reset($attemptKey);

            /**
             * 📊 Registramos sucesso.
             */
            $this->auditService->log(
                event: 'login_success',
                userId: $user->id,
                ip: $ip,
                userAgent: $userAgent
            );

            /**
             * 📦 Retornamos payload estruturado.
             */
            return [
                'access_token' => $token,
                'token_type'   => 'bearer',
                'expires_in'   => $this->authService->getTTL() * 60
            ];

        } catch (\Exception $e) {

            /**
             * ❌ Senha incorreta → incrementa tentativa.
             */
            $this->loginAttemptService->increment($attemptKey);

            $this->auditService->log(
                event: 'login_failed',
                userId: $user->id,
                ip: $ip,
                userAgent: $userAgent,
                metadata: [
                    'reason' => 'invalid_password'
                ]
            );

            throw new \Exception('Credenciais inválidas');
        }
    }
}