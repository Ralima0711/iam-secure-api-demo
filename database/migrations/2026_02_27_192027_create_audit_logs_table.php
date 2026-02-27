<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tabela responsável por registrar
 * eventos de segurança da aplicação.
 *
 * Aqui armazenamos tentativas de login,
 * sucesso, falha e informações de contexto.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();

            // ID do usuário (nullable em caso de falha)
            $table->unsignedBigInteger('user_id')->nullable();

            // Tipo do evento (ex: login_success, login_failed)
            $table->string('event');

            // Endereço IP da requisição
            $table->string('ip_address')->nullable();

            // User agent do navegador/dispositivo
            $table->text('user_agent')->nullable();

            // Dados adicionais em formato JSON
            $table->json('metadata')->nullable();

            $table->timestamps();

            $table->index('event');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};