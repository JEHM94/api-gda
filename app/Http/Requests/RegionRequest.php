<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
//
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegionRequest extends FormRequest
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
        // Reglas de Validación de Formulario para Crear nueva Región
        return [
            'description' => ['required', 'string'],
        ];
    }

    public function messages()
    {
        // Mensajes para las Reglas de Validación de Formulario para Crear nueva Región
        return [
            'description' => 'La descripcion es obligatoria',
            'status' => 'El estatus es obligatorio',
            'status.in' => 'Solo están permitidos los estatus: A:Activo, I:Inactivo, Trash:Eliminado',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Registra log de entrada
        Log::info($this->ip() . " | Intento de creación de Región fallido - {$validator->errors()}");

        throw new HttpResponseException(
            response()->json([
                'errors' => $validator->errors(),
                'success' => false
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
