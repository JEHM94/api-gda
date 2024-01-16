<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Respuesta personalizada para el servicio de mostrar Clientes
        return [
            'name' => $this->name,
            'last_name' => $this->last_name,
            'address' => $this->address ?? null,
            'region' => $this->region->description,
            'commune' => $this->commune->description
        ];
    }
}
