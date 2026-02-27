<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, string $permission)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Não autenticado'], 401);
        }

        if (!$user->hasPermission($permission)) {
            return response()->json(['error' => 'Acesso negado (Permissão)'], 403);
        }

        return $next($request);
    }
}