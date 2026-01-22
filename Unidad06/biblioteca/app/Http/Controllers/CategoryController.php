<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

class CategoryController extends Controller
{
    // Listar categorías
    public function index()
    {
        $categories = Category::with('books')->get();
        return view('categories.index', compact('categories'));
    }

    // Mostrar una categoría
    public function show(Category $category)
    {
        $category->load('books');
        return view('categories.show', compact('category'));
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

