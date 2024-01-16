<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Respuesta personalizada para el servicio de mostrar Comunas
        return [
            'id' => $this->id,
            'description' => $this->description,
            'status' => $this->status,
            'region' => $this->region,
        ];
    }
}
