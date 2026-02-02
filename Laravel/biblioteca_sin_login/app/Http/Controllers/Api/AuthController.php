<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controlador de autenticación API
 *
 * Gestiona el inicio y cierre de sesión mediante tokens de API (Laravel Sanctum)
 */
class AuthController extends Controller
{
    /**
     * Iniciar sesión y generar token de acceso
     *
     * Método HTTP: POST
     * Ruta típica: /api/login
     *
     * @param Request $request Contiene email y password del usuario
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        // Validación de datos
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Buscar usuario por email
        $user = User::where('email', $request->email)->first();

        // Verificar usuario y contraseña
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales incorrectas.',
            ], 401);
        }

        // Crear token de acceso
        $token = $user->createToken('api-token')->plainTextToken;

        // Respuesta exitosa
        return response()->json([
            'success'      => true,
            'access_token' => $token,
            'token_type'   => 'Bearer',
            'user'         => $user,
        ]);
    }

    /**
     * Cerrar sesión y revocar el token actual
     *
     * Método HTTP: POST
     * Ruta típica: /api/logout
     * Requiere: auth:sanctum
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        // Revoca el token actual
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Sesión cerrada correctamente.',
        ]);
    }
}
