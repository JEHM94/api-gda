<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
//
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegistroRequest extends FormRequest
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
        // Reglas de Validación de Formulario para Crear nuevo Usuario
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                'min:8'
            ],
        ];
    }

    public function messages()
    {
        // Mensajes para las Reglas de Validación de Formulario para Crear nuevo Usuario
        return [
            'name' => 'El nombre es obligatorio',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email ya se encuentra registrado',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden. ',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Registra log de entrada
        Log::info($this->ip() . " | Intento de creación de Usuario fallido - {$validator->errors()}");
        
        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
                'success' => false
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
