<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Category;

class BookController extends Controller
{
    // Listar libros
    public function index()
    {
        $books = Book::with(['author', 'categories'])->get();

        return view('books.index', compact('books'));
    }


    public function create()
    {
        $authors = Author::all();
        $categories = Category::all();

        return view('books.create', compact('authors', 'categories'));
    }



    // Mostrar un libro
    public function show(Book $book)
    {
        $book->load(['author', 'categories', 'loans']);
        return view('books.show', compact('book'));
    }
    public function edit(Book $book)
    {
        $authors = Author::all();
        $categories = Category::all();

        return view('books.edit', compact('book', 'authors', 'categories'));
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

    if ($request->has('categories')) {
        $book->categories()->sync($request->categories);
    }

    return redirect('/books')
        ->with('success', 'Libro creado correctamente');
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

         return redirect('/books')
        ->with('success', 'Libro actualizado correctamente');
    }



    // Eliminar libro
public function destroy(Book $book)
{
    if (!$book->isAvailable()) {
        return redirect('/books')
            ->with('error', 'No se puede eliminar un libro con préstamos activos');
    }

    $book->delete();

    return redirect('/books')
        ->with('success', 'Libro eliminado correctamente');
}

}
