<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Mostrar listado paginado de categorías (GET /categories)
    public function index()
    {
        // Obtener categorías ordenadas por nombre, 10 por página
        $categories = Category::query()
            ->orderBy('name')
            ->paginate(10);

        // Renderizar la vista 'categories.index' con la variable $categories
        return view('categories.index', compact('categories'));
    }

    // Mostrar formulario para crear una nueva categoría (GET /categories/create)
    public function create()
    {
        return view('categories.create');
    }

    // Guardar una nueva categoría (POST /categories)
    public function store(Request $request)
    {
        // Validar la entrada: nombre obligatorio, string, longitud 2-100
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        // Crear la categoría usando asignación masiva y generando el slug
        Category::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']), // slug URL-friendly
        ]);

        // Redirigir al índice con un mensaje flash
        return redirect()
            ->route('categories.index')
            ->with('message', 'Categoría creada');
    }

    // Mostrar formulario para editar una categoría existente (GET /categories/{category}/edit)
    public function edit(Category $category)
    {
        // Route-model binding inyecta el modelo $category
        return view('categories.edit', compact('category'));
    }

    // Actualizar una categoría (PUT/PATCH /categories/{category})
    public function update(Request $request, Category $category)
    {
        // Validación similar a store()
        $data = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        // Actualizar nombre y slug
        $category->update([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
        ]);

        // Volver al índice con mensaje
        return redirect()
            ->route('categories.index')
            ->with('message', 'Categoría actualizada');
    }

    // Eliminar una categoría (DELETE /categories/{category})
    public function destroy(Category $category)
    {
        // Borrar el registro (si existe soft deletes, será soft)
        $category->delete();

        // Redirigir con mensaje de confirmación
        return redirect()
            ->route('categories.index')
            ->with('message', 'Categoría eliminada');
    }
}
