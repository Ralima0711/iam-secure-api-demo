<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        if (!$user->hasRole($role)) {
            return response()->json(['error' => 'Acesso negado (Role)'], 403);
        }

        return $next($request);
    }
}