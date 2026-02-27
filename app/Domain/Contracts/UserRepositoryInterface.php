<?php

namespace App\Domain\Contracts;

/**
 * Interface responsável por definir
 * as operações de acesso a dados do usuário.
 *
 * A camada Application depende dessa interface,
 * e NÃO de Eloquent ou banco de dados.
 *
 * Isso aplica o princípio da Inversão de Dependência (DIP).
 */
interface UserRepositoryInterface
{
    /**
     * Busca usuário por e-mail.
     *
     * @param string $email
     * @return mixed
     */
    public function findByEmail(string $email): mixed;

    /**
     * Busca usuário por ID.
     *
     * @param int $id
     * @return mixed
     */
    public function findById(int $id): mixed;

    /**
     * Cria novo usuário.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;
}