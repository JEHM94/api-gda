<?php

namespace App\Http\Controllers;

use App\Models\Commune;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\CustomerRequest;
use App\Http\Resources\CustomerCollection;

class CustomerController extends Controller
{
    /**
     * Servicio para mostrar todos los Clientes activos
     */
    public function index(Request $request)
    {
        // Registra log de salida
        Log::debug($request->ip() . " | Solicitud de información de Clientes");

        return [
            'data' => new CustomerCollection(Customer::where('status', 'A')->get()),
            'success' => true
        ];
    }

    /**
     * Servicio para crear un nuevo Cliente
     */
    public function store(CustomerRequest $request)
    {
        // Validación del formulario de creación Cliente
        $data = $request->validated();

        // Valida que la relación entre comuna y región sea correcta
        $commune = Commune::find($data['commune_id']);
        if ($commune->region_id != $data['region_id']) {

            // Registra log de entrada
            Log::info($request->ip() . " | Intento de registro de cliente fallido (Relación entre Comuna y Region incorrecta)");

            return response([
                'errors' => ['Relación entre Comuna y Region incorrecta'],
                'success' => false
            ], 422);
        }

        // Registra un nuevo Cliente
        $customer = Customer::create([
            'dni' => $data['dni'],
            'email' => $data['email'],
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'address' => $data['address'],
            'region_id' => $data['region_id'],
            'commune_id' => $data['commune_id'],
        ]);

        // Registra log de entrada
        Log::info($request->ip() . " | Nuevo cliente registrado - Cliente: $customer->name $customer->last_name");

        return [
            'success' => true
        ];
    }

    /**
     * Servicio para buscar y mostrar un Cliente
     */
    public function show(Request $request, $identifier)
    {
        try {
            // Busca el cliente por su DNI y Estatus "A" o por su Emai y Estatus "A"
            $customer = Customer::where('dni', $identifier)->where('status', 'A')
                ->orWhere('email', $identifier)->where('status', 'A')
                ->firstOrFail();

        } catch (\Throwable $th) {
            // Registra log de salida
            Log::debug($request->ip() . " | Solicitud de información de Cliente fallida (Cliente no existe)");

            return response([
                'errors' => ['Registro no existe'],
                'success' => false
            ], 404);
        }

        // Registra log de salida
        Log::debug($request->ip() . " | Solicitud de información de Cliente - Cliente: $customer->name $customer->last_name");

        return [
            'customer' => [
                'name' => $customer->name,
                'last_name' => $customer->last_name,
                'address' => $customer->address ?? null,
                'region' => $customer->region->description,
                'commune' => $customer->commune->description
            ],
            'success' => true
        ];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        //
    }

    /**
     * Servicio para eliminar un Cliente
     */
    public function destroy(Request $request, $identifier)
    {
        try {
            // Busca el cliente por su DNI y Estatus "A" o por su Emai y Estatus "A"
            $customer = Customer::where('dni', $identifier)->whereIn('status', ['A', 'I'])
                ->orWhere('email', $identifier)->whereIn('status', ['A', 'I'])
                ->firstOrFail();

        } catch (\Throwable $th) {

            // Registra log de entrada
            Log::info($request->ip() . " | Intento de eliminación de cliente fallido (Cliente no existe) - Cliente: Identificador-$identifier");

            return response([
                'errors' => ['Registro no existe'],
                'success' => false
            ], 404);
        }

        // Cambia el estado del Cliente a Trash (eliminado)
        $customer->status = 'Trash';
        $customer->save();

        // Registra log de entrada
        Log::info($request->ip() . " | Eliminación de cliente exitosa - Cliente: DNI-$customer->dni $customer->name $customer->last_name");

        return [
            'message' => 'Registro eliminado',
            'success' => true
        ];
    }
}
