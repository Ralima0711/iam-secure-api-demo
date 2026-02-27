<?php

namespace App\Domain\Contracts;

interface AuthServiceInterface
{
    public function attempt(string $email, string $password): string;

    public function refresh(): string;

    public function logout(): void;

    public function user(): mixed;

    public function getTTL(): int;
}