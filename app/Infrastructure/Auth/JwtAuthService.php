<?php

namespace App\Infrastructure\Auth;

use App\Domain\Contracts\AuthServiceInterface;

class JwtAuthService implements AuthServiceInterface
{
    public function attempt(string $email, string $password): string
    {
        $token = auth('api')->attempt([
            'email' => $email,
            'password' => $password
        ]);

        if (!$token) {
            throw new \Exception('Credenciais inválidas');
        }

        return $token;
    }

    public function refresh(): string
    {
        return auth('api')->refresh();
    }

    public function logout(): void
    {
        auth('api')->logout();
    }

    public function user(): mixed
    {
        return auth('api')->user();
    }

    public function getTTL(): int
    {
        return auth('api')->factory()->getTTL();
    }
}