<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Mostrar listado de libros con paginación y filtros básicos.
     * Parámetros de query: ?availability=all|available|borrowed
     */
    public function index(Request $request)
    {
        // Leer filtro de disponibilidad (por defecto 'all')
        $availability = $request->query('availability', 'all'); // all | available | borrowed

        // Consulta base con eager loading de relaciones usadas en la vista
        $query = Book::query()
            ->with(['author', 'categories'])
            ->orderBy('title');

        if ($availability === 'available') {
            // Filtrar libros que NO tienen préstamos abiertos
            $query->whereDoesntHave('loans', function ($q) {
                $q->where('is_open', true);
            });
        } elseif ($availability === 'borrowed') {
            // Filtrar libros que SÍ tienen préstamos abiertos
            $query->whereHas('loans', function ($q) {
                $q->where('is_open', true);
            });
        }

        // Paginación (10 por página) y mantener la query string en los enlaces
        $books = $query->paginate(10)->withQueryString();

        // Renderizar la vista 'books.index' pasando variables
        return view('books.index', compact('books', 'availability'));
    }

    /**
     * Mostrar formulario para crear un libro.
     * Carga autores y categorías para selects en el formulario.
     */
    public function create()
    {
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('books.create', compact('authors','categories'));
    }

    /**
     * Almacenar un libro nuevo.
     * Valida entrada, crea el libro y sincroniza categorías.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'nullable|string|unique:books,isbn',
            'published_year' => 'nullable|integer',
            'author_id' => 'nullable|exists:authors,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $book = Book::create($data);
        // Sincroniza pivot table
        $book->categories()->sync($data['categories'] ?? []);
        return redirect()->route('books.index')->with('message','Libro creado');
    }

    /**
     * Mostrar formulario de edición para un libro existente.
     * Carga relaciones y listas necesarias para el formulario.
     */
    public function edit(Book $book)
    {
        $authors = Author::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $book->load('categories'); // asegurar relación cargada
        return view('books.edit', compact('book','authors','categories'));
    }

    /**
     * Actualizar un libro.
     * Valida entrada, actualiza campos y sincroniza categorías.
     */
    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => "nullable|string|unique:books,isbn,{$book->id}",
            'published_year' => 'nullable|integer',
            'author_id' => 'nullable|exists:authors,id',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $book->update($data);
        // Sincroniza pivot table (añade/quita según selección)
        $book->categories()->sync($data['categories'] ?? []);
        return redirect()->route('books.index')->with('message','Libro actualizado');
    }

    /**
     * Eliminar un libro.
     * Realiza el borrado (soft delete si el modelo usa SoftDeletes).
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('message', 'Libro eliminado');
    }

    /**
     * Mostrar detalles de un libro.
     * Carga relaciones necesarias para la vista de detalles.
     */
    public function show(Book $book)
    {
        $book->load(['author', 'categories']);
        return view('books.show', compact('book'));
    }
}
