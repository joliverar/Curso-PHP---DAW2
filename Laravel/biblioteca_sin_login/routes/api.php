<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AuthorController;

// --------------------------------------------------
// RUTAS PÚBLICAS
// --------------------------------------------------

Route::post('/login', [AuthController::class, 'login']);


// --------------------------------------------------
// RUTAS PROTEGIDAS (requieren token Sanctum)
// --------------------------------------------------

Route::middleware('auth:sanctum')->group(function () {

    // Obtener datos del usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout']);

    // Recursos de la API (Autores, Libros, etc.)
    Route::apiResource('authors', AuthorController::class);
});
