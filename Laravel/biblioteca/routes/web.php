<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LoanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::resource('authors', AuthorController::class);
Route::resource('categories', CategoryController::class);
Route::resource('books', BookController::class);
// Resource SIN show, edit ni update (no se usan)
Route::resource('loans', LoanController::class)
    ->except(['show', 'edit', 'update']);

// Ruta específica para devolver un libro
Route::put('loans/{loan}/return', [LoanController::class, 'return'])
    ->name('loans.return');

?>
