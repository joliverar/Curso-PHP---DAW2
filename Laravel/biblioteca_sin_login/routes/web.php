<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('books.index');
});

// Rutas públicas sin autenticación
Route::resource('authors', AuthorController::class);
Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);

// Préstamos (ajusta según controlador)
Route::resource('loans', LoanController::class)->except(['edit', 'update']);
Route::post('loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');
