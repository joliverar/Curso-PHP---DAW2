<?php

use App\Http\Controllers\{
    AuthorController,
    BookController,
    CategoryController,
    LoanController,
    CatalogoController
};
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | RUTA RAÍZ
 * |--------------------------------------------------------------------------
 * | Punto de entrada único del sistema
 */
Route::get('/', function () {
    return redirect()->route('catalogo.index');
});

/*
 * |--------------------------------------------------------------------------
 * | DASHBOARD (JETSTREAM)
 * |--------------------------------------------------------------------------
 * | Tras login, todos los usuarios van al catálogo
 */
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->get('/dashboard', function () {
    return redirect()->route('catalogo.index');
})->name('dashboard');

/*
 * |--------------------------------------------------------------------------
 * | CATÁLOGO (TODOS LOS USUARIOS AUTENTICADOS)
 * |--------------------------------------------------------------------------
 */
Route::middleware(['auth'])
    ->get('/catalogo', [CatalogoController::class, 'index'])
    ->name('catalogo.index');

/*
 * |--------------------------------------------------------------------------
 * | AUTORES Y CATEGORÍAS (VISUALIZACIÓN)
 * |--------------------------------------------------------------------------
 * | Socio, Bibliotecario y Admin pueden VER
 */
Route::middleware(['auth'])->group(function () {
    // Autores
    Route::get('/authors', [AuthorController::class, 'index'])->name('authors.index');
    Route::get('/authors/{author}', [AuthorController::class, 'show'])->name('authors.show');

    // Categorías
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
});

/*
 * |--------------------------------------------------------------------------
 * | PRÉSTAMOS – SOCIO
 * |--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'role:user,librarian,admin'])->group(function () {
    Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
    Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
});

/*
 * |--------------------------------------------------------------------------
 * | GESTIÓN – BIBLIOTECARIO / ADMIN
 * |--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'role:librarian,admin'])->group(function () {
    // Gestión de préstamos
    Route::get('/loans/all', [LoanController::class, 'indexAll'])->name('loans.all');
    Route::post('/loans/{id}/approve', [LoanController::class, 'approve'])->name('loans.approve');
    Route::post('/loans/{id}/reject', [LoanController::class, 'reject'])->name('loans.reject');
    Route::post('/loans/{id}/return', [LoanController::class, 'markAsReturned'])->name('loans.return');

    // Gestión de libros
    Route::resource('books', BookController::class)->except(['show']);

    // Gestión de autores (CRUD)
    Route::resource('authors', AuthorController::class)->except(['index', 'show']);

    // Gestión de categorías (CRUD)
    Route::resource('categories', CategoryController::class)->except(['index', 'show']);

    // Estadísticas
    Route::get('/estadisticas', fn() => view('estadisticas.index'))
        ->name('estadisticas.index');
});

/*
 * |--------------------------------------------------------------------------
 * | ADMINISTRACIÓN – SOLO ADMIN
 * |--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'role:admin'])
    ->get('/admin', fn() => view('admin.index'))
    ->name('admin.index');
