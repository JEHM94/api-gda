<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
//
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Reglas de Validación de Formulario para Inicio de Sesión
        return [
            //
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required'],
        ];
    }

    public function messages()
    {
        // Mensajes para las Reglas de Validación de Formulario para Iniciar Sesión
        return [
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.exists' => 'Email no registrado',
            'password' => 'El password es obligatorio',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Registra log de entrada
        Log::info($this->ip() . " | Intento de Inicio de Sesión fallido - {$validator->errors()}");
        
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
                'success' => false
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
