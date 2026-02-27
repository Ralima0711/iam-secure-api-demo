<?php

namespace App\Domain\Contracts;

/**
 * Interface responsável por controlar
 * tentativas de login e bloqueios temporários.
 */
interface LoginAttemptServiceInterface
{
    public function tooManyAttempts(string $key): bool;

    public function increment(string $key): void;

    public function reset(string $key): void;
}