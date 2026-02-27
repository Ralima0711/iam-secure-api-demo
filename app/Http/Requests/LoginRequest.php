<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request responsável por validar
 * dados de autenticação.
 *
 * Aqui aplicamos:
 * - Single Responsibility Principle
 * - Separação entre validação e controller
 */
class LoginRequest extends FormRequest
{
    /**
     * Define se a requisição pode ser autorizada.
     * Como é login público, retornamos true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Regras de validação.
     * Centralizamos aqui as regras
     * ao invés de colocar no Controller.
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    /**
     * Mensagens personalizadas (opcional).
     * Deixa mais profissional.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter pelo menos 6 caracteres.',
        ];
    }
}