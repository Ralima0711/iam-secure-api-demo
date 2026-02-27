<?php

namespace App\Infrastructure\Security;

use App\Domain\Contracts\LoginAttemptServiceInterface;
use Illuminate\Support\Facades\Cache;

/**
 * Implementação concreta usando Cache do Laravel.
 *
 * Controla limite de tentativas por IP.
 */
class LoginAttemptCacheService implements LoginAttemptServiceInterface
{
    private int $maxAttempts = 5;
    private int $decaySeconds = 300; // 5 minutos

    public function tooManyAttempts(string $key): bool
    {
        return Cache::get($key, 0) >= $this->maxAttempts;
    }

    public function increment(string $key): void
    {
        Cache::add($key, 0, $this->decaySeconds);
        Cache::increment($key);
        Cache::put($key, Cache::get($key), $this->decaySeconds);
    }

    public function reset(string $key): void
    {
        Cache::forget($key);
    }
}