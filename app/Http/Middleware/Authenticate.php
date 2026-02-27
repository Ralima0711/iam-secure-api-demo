<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Para API nunca redirecionar
        if (!$request->expectsJson()) {
            return null;
        }

        return null;
    }

    /**
     * Handle unauthenticated users for API.
     */
    protected function unauthenticated($request, array $guards)
    {
        abort(response()->json([
            'error' => 'Não autenticado'
        ], 401));
    }
}