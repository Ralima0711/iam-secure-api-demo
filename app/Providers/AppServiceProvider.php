<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Contracts\AuthServiceInterface;
use App\Infrastructure\Auth\JwtAuthService;
use App\Domain\Contracts\UserRepositoryInterface;
use App\Infrastructure\Persistence\EloquentUserRepository;
use App\Domain\Contracts\AuditServiceInterface;
use App\Infrastructure\Logging\AuditDatabaseService;
use App\Domain\Contracts\LoginAttemptServiceInterface;
use App\Infrastructure\Security\LoginAttemptCacheService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // 🔐 Bind da autenticação
        $this->app->bind(
            AuthServiceInterface::class,
            JwtAuthService::class
        );

        // 👤 Bind do repositório de usuário
        $this->app->bind(
            UserRepositoryInterface::class,
            EloquentUserRepository::class
        );

        $this->app->bind(
            AuditServiceInterface::class,
            AuditDatabaseService::class
        );

        $this->app->bind(
            LoginAttemptServiceInterface::class,
            LoginAttemptCacheService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
