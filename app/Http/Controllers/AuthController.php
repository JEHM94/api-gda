<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegistroRequest;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    public function register(RegistroRequest $request)
    {
        // Validación del formulario de registro de usuario
        $data = $request->validated();

        // Crea un nuevo usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Crea el token de acceso personal con tiempo de expiración de 1 semana
        $token = $user->createToken('Token - ' . $user->name, ['*'], now()->addWeek())->plainTextToken;
        $tokenUpdate = PersonalAccessToken::findToken($token);
        $tokenUpdate->email = $user->email;
        $tokenUpdate->random = sha1(rand(200, 500));
        $tokenUpdate->save();

        // Registra log de entrada
        Log::info($request->ip() . " | Nuevo usuario registrado - Usuario: ID-$user->id $user->name");

        // Autentica al usuario registrado  y retorna con el token de acceso personal
        return [
            'token' => $token,
            'user' => $user,
            'success' => true
        ];
    }

    public function login(LoginRequest $request)
    {
        // Validación del formulario de login
        $data = $request->validated();

        // Valida la Contraseña
        if (!Auth::attempt($data)) {

            // Registra log de entrada
            $email = $data['email'];
            Log::info($request->ip() . " | Intento de inicio de sesión fallido - Email o Contraseña incorrecto. Email:$email");

            return response([
                'errors' => ['El email o la contraseña no coinciden'],
                'success' => false
            ], 422);
        }

        // Autentica al usuario y retorna con el token de acceso personal
        $user = Auth::user();

        // Crea el token de acceso personal para el usuario
        $token = $user->createToken('Token - ' . $user->name, ['*'], now()->addWeek())->plainTextToken;
        $tokenUpdate = PersonalAccessToken::findToken($token);
        $tokenUpdate->email = $user->email;
        $tokenUpdate->random = sha1(rand(200, 500));
        $tokenUpdate->save();

        // Registra log de entrada
        Log::info($request->ip() . " | Inicio de sesión exitoso - Usuario: ID-$user->id $user->name");

        return [
            'token' => $token,
            'user' => $user,
            'success' => true
        ];
    }

    public function logout(Request $request)
    {
        // Termina la sesión del usuario revocando su token de acceso personal
        $user = $request->user();
        $user->currentAccessToken()->delete();

        // Registra log de salida
        Log::debug($request->ip() . " | Sesión de usuario desconectada - Usuario: ID-$user->id $user->name");

        return [
            'message' => 'logged out',
            'user' => null,
            'success' => true
        ];
    }
}
