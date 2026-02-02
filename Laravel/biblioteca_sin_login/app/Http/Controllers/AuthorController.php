<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Mostrar lista paginada de autores.
     * Método HTTP: GET
     * Ruta típica: authors.index
     */
    public function index()
    {
        // Crea la consulta, ordena por nombre y pagina 10 por página
        $authors = Author::query()
            ->orderBy('name')
            ->paginate(10);

        // Renderiza la vista authors.index pasando la variable $authors
        return view('authors.index', compact('authors'));
    }

    /**
     * Mostrar formulario para crear un autor.
     * Método HTTP: GET
     * Ruta típica: authors.create
     */
    public function create()
    {
        return view('authors.create');
    }

    /**
     * Guardar un nuevo autor en la base de datos.
     * Método HTTP: POST
     * Ruta típica: authors.store
     */
    public function store(Request $request)
    {
        // Valida los datos de entrada
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2'],     // nombre obligatorio, texto, mínimo 2
            'country' => ['nullable', 'string', 'max:100'],// país opcional
            'birth_date' => ['nullable', 'date'],          // fecha opcional, debe ser fecha válida
        ]);

        // Crea el autor usando mass assignment (Author debe tener $fillable con estos campos)
        Author::create($data);

        // Redirige a la lista con un mensaje flash en sesión
        return redirect()
            ->route('authors.index')
            ->with('message', 'Autor creado');
    }

    /**
     * Mostrar formulario para editar un autor.
     * Route‑model binding: recibe un Author ya resuelto.
     * Método HTTP: GET
     * Ruta típica: authors.edit
     */
    public function edit(Author $author)
    {
        // Pasa el modelo $author a la vista
        return view('authors.edit', compact('author'));
    }

    /**
     * Actualizar los datos de un autor existente.
     * Método HTTP: PUT/PATCH
     * Ruta típica: authors.update
     */
    public function update(Request $request, Author $author)
    {
        // Valida los datos entrantes (mismas reglas que en store)
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2'],
            'country' => ['nullable', 'string', 'max:100'],
            'birth_date' => ['nullable', 'date'],
        ]);

        // Actualiza el modelo con los datos validados
        $author->update($data);

        // Redirige a la lista con mensaje
        return redirect()
            ->route('authors.index')
            ->with('message', 'Autor actualizado');
    }

    /**
     * Eliminar un autor.
     * Método HTTP: DELETE
     * Ruta típica: authors.destroy
     */
    public function destroy(Author $author)
    {
        // Borra el registro (si usas softDeletes, será soft delete)
        $author->delete();

        // Redirige a la lista con mensaje
        return redirect()
            ->route('authors.index')
            ->with('message', 'Autor eliminado');
    }

    /**
     * Mostrar un autor (Route::resource espera este método)
     */
    public function show(Author $author)
    {
        return view('authors.show', compact('author'));
    }
}
