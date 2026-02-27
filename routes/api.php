<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Todas as rotas aqui possuem prefixo automático /api
| Exemplo: /api/login
|
*/

/*
|--------------------------------------------------------------------------
| 🔐 ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {

    // Login - gera JWT
    Route::post('/login', [AuthController::class, 'login']);

});


/*
|--------------------------------------------------------------------------
| 🔒 ROTAS PROTEGIDAS (JWT)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | 👤 Autenticação
    |--------------------------------------------------------------------------
    */

    Route::prefix('auth')->group(function () {

        // Dados do usuário autenticado
        Route::get('/me', [AuthController::class, 'me']);

        // Refresh token
        Route::post('/refresh', [AuthController::class, 'refresh']);

        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });


    /*
    |--------------------------------------------------------------------------
    | 🔥 ROTAS PROTEGIDAS POR ROLE
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:ADMIN')->group(function () {

        Route::get('/admin-only', function () {
            return response()->json([
                'message' => 'Área exclusiva para ADMIN'
            ]);
        });

    });


    /*
    |--------------------------------------------------------------------------
    | 🔥 ROTAS PROTEGIDAS POR PERMISSION
    |--------------------------------------------------------------------------
    */

    Route::middleware('permission:create_user')->group(function () {

        Route::get('/users/create-area', function () {
            return response()->json([
                'message' => 'Permissão create_user validada'
            ]);
        });

    });

});