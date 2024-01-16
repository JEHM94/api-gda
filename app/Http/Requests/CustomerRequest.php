<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;

//
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomerRequest extends FormRequest
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
        // Reglas de Validación de Formulario para Crear nuevo Cliente
        return [
            'dni' => ['required', 'string', 'unique:customers,dni'],
            'email' => ['required', 'email', 'unique:customers,email'],
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'address' => ['required', 'string'],
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'commune_id' => ['required', 'integer', 'exists:communes,id'],
        ];
    }

    public function messages()
    {
        // Mensajes para las Reglas de Validación de Formulario para Crear nuevo Cliente
        return [
            'dni' => 'El DNI es obligatorio',
            'dni.unique' => 'El DNI ya se encuentra registrado',
            'email.required' => 'El email es obligatorio',
            'email.email' => 'El email no es válido',
            'email.unique' => 'El email ya se encuentra registrado',
            'name' => 'El nombre es obligatorio',
            'last_name' => 'El apellido es obligatorio',
            'address' => 'La dirección es obligatoria',
            'region_id' => 'El ID de la Región obligatorio',
            'region_id.exists' => 'El ID de la Región no es válido',
            'commune_id' => 'El ID de la Comuna obligatorio',
            'commune_id.exists' => 'El ID de la Comuna no es válido',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Registra log de entrada
        Log::info($this->ip() . " | Intento de creación de Cliente fallido - {$validator->errors()}");

        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
                'success' => false
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
