<?php

namespace App\Http\Controllers;

use App\Application\UseCases\LoginUseCase;
use App\Http\Requests\LoginRequest;

/**
 * 🔐 AuthController
 *
 * Camada de Interface (HTTP) da aplicação.
 *
 * Responsabilidades:
 * - Receber requisições HTTP
 * - Delegar execução para UseCases
 * - Traduzir resposta da aplicação para HTTP
 *
 * NÃO contém:
 * - Regra de negócio
 * - Acesso direto ao banco
 * - Lógica de autenticação
 *
 * Princípios aplicados:
 * - SRP (Single Responsibility Principle)
 * - Clean Architecture
 * - Separação de camadas
 */
class AuthController extends Controller
{
    /**
     * 🔐 LOGIN
     *
     * Fluxo arquitetural:
     *
     * HTTP → LoginRequest (validação)
     *      → LoginUseCase (regra)
     *      → AuthService (infra)
     *
     * Aqui apenas orquestramos.
     */
    public function login(LoginRequest $request, LoginUseCase $useCase)
    {
        try {
            $result = $useCase->execute(
                $request->email,
                $request->password,
                $request->ip(),          // 🔎 IP capturado para auditoria
                $request->userAgent()    // 🖥 User Agent capturado para auditoria
            );

            return response()->json($result);

        } catch (\Exception $e) {

            // 🔒 Nunca expor detalhes internos de autenticação
            return response()->json([
                'error' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * 👤 ME
     *
     * Retorna dados do usuário autenticado.
     *
     * Ainda utiliza infraestrutura direta (auth('api')),
     * mas pode ser evoluído para um UseCase específico.
     *
     * Protegido via middleware auth:api.
     */
    public function me()
    {
        $user = auth('api')->user();

        return response()->json([
            'id'    => $user->id,
            'name'  => $user->name,
            'email' => $user->email,
            'roles' => $user->roles->pluck('name')
        ]);
    }

    /**
     * ♻️ REFRESH
     *
     * Gera novo token baseado no token atual.
     *
     * Pode ser extraído futuramente para RefreshTokenUseCase.
     */
    public function refresh()
    {
        return response()->json([
            'access_token' => auth('api')->refresh(),
            'token_type'   => 'bearer',
            'expires_in'   => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * 🚪 LOGOUT
     *
     * Invalida o token atual.
     *
     * Responsabilidade:
     * - Apenas acionar o mecanismo de autenticação.
     *
     * Evolução possível:
     * - Criar LogoutUseCase
     * - Registrar evento de auditoria
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'message' => 'Logout realizado com sucesso'
        ]);
    }
}