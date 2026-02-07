<?php

use App\Http\Controllers\PeliculaController;
use App\Http\Controllers\ProyeccionController;
use App\Http\Controllers\SalaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('peliculas', PeliculaController::class);
Route::resource('salas', SalaController::class);
Route::resource('proyecciones', ProyeccionController::class)
    ->parameters(['proyecciones' => 'proyeccion']);
