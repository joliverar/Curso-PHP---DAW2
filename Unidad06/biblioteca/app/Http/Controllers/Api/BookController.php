<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

       // return Book::all();
          $books = Book::query()
            ->orderBy('title')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $books,
        ], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            $validated = $request->validate([
                'title'          => 'required|string|max:255',
                'isbn'           => 'required|string|max:50',
                'published_year' => 'required|integer|min:2000',
                'author_id'      => 'required|exists:authors,id',
            ]);

            $book = Book::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Libro creado correctamente',
                'data'    => $book,
            ], 201);
        }


    /**
     * Display the specified resource.
     */
public function show(Book $book)
{
    return response()->json([
        'success' => true,
        'data'    => $book
    ], 200);
}


    /**
     * Update the specified resource in storage.
     */
public function update(Request $request, Book $book)
{
    $validated = $request->validate([
        'title'          => 'sometimes|required|string|max:255',
        'isbn'           => 'sometimes|required|string|max:50',
        'published_year' => 'sometimes|required|integer|min:2000',
        'author_id'      => 'sometimes|required|exists:authors,id',
    ]);

    $book->update($validated);

    return response()->json([
        'success' => true,
        'message' => 'Libro actualizado correctamente',
        'data'    => $book
    ], 200);
}


    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Book $book)
{
    $book->delete();

    return response()->json([
        'success' => true,
        'message' => 'Libro eliminado correctamente'
    ], 200);
}

}
