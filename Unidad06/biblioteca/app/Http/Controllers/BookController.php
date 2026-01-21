<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    // Listar libros
    public function index()
    {
        return Book::with(['author', 'categories'])->get();
    }

    // Mostrar un libro
    public function show(Book $book)
    {
        return $book->load(['author', 'categories', 'loans']);
    }

    // Crear libro y asignar categorías
    public function store(Request $request)
    {
        $book = Book::create($request->only([
            'title',
            'isbn',
            'published_year',
            'author_id'
        ]));

        // Sincronizar categorías
        if ($request->has('categories')) {
            $book->categories()->sync($request->categories);
        }

        return $book->load(['author', 'categories']);
    }

    // Actualizar libro
    public function update(Request $request, Book $book)
    {
        $book->update($request->only([
            'title',
            'isbn',
            'published_year',
            'author_id'
        ]));

        if ($request->has('categories')) {
            $book->categories()->sync($request->categories);
        }

        return $book->load(['author', 'categories']);
    }

    // Eliminar libro
    public function destroy(Book $book)
    {
        if (!$book->isAvailable()) {
            return response()->json([
                'error' => 'El libro tiene préstamos activos'
            ], 409);
        }

        $book->delete();
        return response()->noContent();
    }
}
