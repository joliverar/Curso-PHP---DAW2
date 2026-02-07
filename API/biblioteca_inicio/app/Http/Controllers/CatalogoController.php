<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CatalogoController extends Controller
{
    public function index()
    {
        $books = Book::with('author')
            ->orderBy('title')
            ->get();

        return view('catalogo.index', compact('books'));
    }
}
