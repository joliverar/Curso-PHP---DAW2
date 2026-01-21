<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    // Listar autores
  public function index()
{
    $authors = Author::with('books')->get();
    return view('authors.index', compact('authors'));
}


    public function show(Author $author)
{
    $author->load('books');
    return view('authors.show', compact('author'));
}

    // Crear autor
    public function store(Request $request)
    {
        $author = Author::create($request->only([
            'name',
            'country',
            'birth_date'
        ]));

        return $author;
    }

    // Actualizar autor
    public function update(Request $request, Author $author)
    {
        $author->update($request->only([
            'name',
            'country',
            'birth_date'
        ]));

        return $author;
    }

    // Eliminar autor
    public function destroy(Author $author)
    {
        $author->delete();
        return response()->noContent();
    }
}
