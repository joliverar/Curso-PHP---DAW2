<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Listar categorías
    public function index()
    {
        return Category::with('books')->get();
    }

    // Mostrar una categoría
    public function show(Category $category)
    {
        return $category->load('books');
    }

    // Crear categoría
    public function store(Request $request)
    {
        $category = Category::create($request->only([
            'name',
            'slug'
        ]));

        return $category;
    }

    // Actualizar categoría
    public function update(Request $request, Category $category)
    {
        $category->update($request->only([
            'name',
            'slug'
        ]));

        return $category;
    }

    // Eliminar categoría
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->noContent();
    }
}

