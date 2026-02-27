<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Contracts\UserRepositoryInterface;
use App\Models\User;

/**
 * Implementação concreta usando Eloquent.
 *
 * Aqui está a infraestrutura real.
 * Se amanhã trocarmos para MongoDB,
 * apenas essa classe muda.
 */
class EloquentUserRepository implements UserRepositoryInterface
{
    public function findByEmail(string $email): mixed
    {
        return User::where('email', $email)->first();
    }

    public function findById(int $id): mixed
    {
        return User::find($id);
    }

    public function create(array $data): mixed
    {
        return User::create($data);
    }
}