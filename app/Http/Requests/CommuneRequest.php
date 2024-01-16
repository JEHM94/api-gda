<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
//
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommuneRequest extends FormRequest
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
        // Reglas de Validación de Formulario para Crear nueva Comuna
        return [
            'region_id' => ['required', 'integer', 'exists:regions,id'],
            'description' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        // Mensajes para las Reglas de Validación de Formulario para Crear nueva Comuna
        return [
            'region_id' => 'El ID de la Región obligatorio',
            'region_id.exists' => 'El ID de la Región no es válido',
            'description' => 'La descripción es obligatoria',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Registra log de entrada
        Log::info($this->ip() . " | Intento de creación de Comuna fallido - {$validator->errors()}");

        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
                'success' => false
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
