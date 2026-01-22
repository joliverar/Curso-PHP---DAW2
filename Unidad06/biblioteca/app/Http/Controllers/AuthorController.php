<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class AuthorController extends Controller
{
    // Listar autores
    public function index()
    {
        $authors = Author::with('books')->get();
        return view('authors.index', compact('authors'));
    }

    // Mostrar formulario de creación
    public function create()
    {
        return view('authors.create');
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

        //return $author;
        return redirect('authors');
    }
    // Mostrar formulario de edición
public function edit(Author $author)
{
    return view('authors.edit', compact('author'));
}

    // Actualizar autor
    public function update(Request $request, Author $author)
    {
        $author->update($request->only([
            'name',
            'country',
            'birth_date'
        ]));

       // return $author;
       return redirect('authors');
    }

    // Eliminar autor
    // public function destroy(Author $author)
    // {
    //     $author->delete();
    //     return response()->noContent();
    // }

    // Eliminar autor
public function destroy(Author $author)
{
    try {
        $author->delete();
        return redirect('/authors')
            ->with('success', 'Autor eliminado correctamente');
    } catch (QueryException $e) {
        return redirect('/authors')
            ->with('error', 'No se puede eliminar el autor porque tiene libros asociados');
    }
}

}
