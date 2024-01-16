<?php

namespace App\Http\Controllers;

use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\RegionRequest;
use App\Http\Resources\RegionsCollection;

class RegionsController extends Controller
{
    /**
     * Servicio para mostrar todas las Regiones
     */
    public function index(Request $request)
    {
        // Registra log de salida
        Log::debug($request->ip() . " | Solicitud de información de Regiones");

        return [
            'data' => new RegionsCollection(Region::with('communes')->where('status', 'A')->get()),
            'success' => true
        ];
    }

    /**
     * Servicio para crear una nueva Región
     */
    public function store(RegionRequest $request)
    {
        // Validación del formulario de creación Región
        $data = $request->validated();

        // Crea una nueva Región
        $region = Region::create([
            'description' => $data['description'],
        ]);

        // Registra log de entrada
        Log::info($request->ip() . " | Registro de Region exitoso - Region: ID-$region->id $region->description");

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
     * Servicio para eliminar una Región
     */
    public function destroy(Request $request, string $id)
    {
        try {
            // Busca la Región a eliminar
            $region = Region::where('id', $id)->whereIn('status', ['A', 'I'])->firstOrFail();

        } catch (\Throwable $th) {

            // Registra log de entrada
            Log::info($request->ip() . " | Intento de eliminación de región fallido (Región no existe) - Region: ID-$id");

            return response([
                'errors' => ['Registro no existe'],
                'success' => false
            ], 404);
        }

        // Cambia el estado de la Región a Trash (eliminado)
        $region->status = 'Trash';
        $region->save();

        // Registra log de entrada
        Log::info($request->ip() . " | Eliminación de Region exitoso - Region: ID-$region->id $region->description");

        return [
            'message' => 'Registro eliminado',
            'success' => true
        ];
    }
}
