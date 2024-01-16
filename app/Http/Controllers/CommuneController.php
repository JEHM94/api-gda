<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CommuneRequest;
use App\Http\Resources\CommunesCollection;

class CommuneController extends Controller
{
    /**
     * Servicio para mostrar todas las Comunas
     */
    public function index(Request $request)
    {
        // Registra log de salida
        Log::debug($request->ip() . " | Solicitud de información de Comunas");

        return [
            'data' => new CommunesCollection(Commune::with('region')->where('status', 'A')->get()),
            'success' => true
        ];
    }

    /**
     * Servicio para crear una nueva Comuna
     */
    public function store(CommuneRequest $request)
    {
        // Validación del formulario de creación Comuna
        $data = $request->validated();

        // Crea una nueva Comuna
        $commune = Commune::create([
            'region_id' => $data['region_id'],
            'description' => $data['description'],
        ]);

        // Registra log de entrada
        Log::info($request->ip() . " | Registro de Comuna exitoso - Comuna: ID-$commune->id $commune->description");

        return [
            'success' => true
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        try {
            // Busca la Comuna a eliminar
            $commune = Commune::where('id', $id)->whereIn('status', ['A', 'I'])->firstOrFail();

        } catch (\Throwable $th) {

            // Registra log de entrada
            Log::info($request->ip() . " | Intento de eliminación de comuna fallido (Comuna no existe) - Comuna: ID-$id");

            return response([
                'errors' => ['Registro no existe'],
                'success' => false
            ], 404);
        }

        // Cambia el estado de la Comuna a Trash (eliminado)
        $commune->status = 'Trash';
        $commune->save();

        // Registra log de entrada
        Log::info($request->ip() . " | Eliminación de Comuna exitoso - Comuna: ID-$commune->id $commune->description");

        return [
            'message' => 'Registro eliminado',
            'success' => true
        ];
    }
}
