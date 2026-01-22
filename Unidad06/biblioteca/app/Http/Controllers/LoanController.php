<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Book;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    // Listar préstamos
    public function index()
    {
        $loans = Loan::with(['user', 'book'])->get();
        return view('loans.index', compact('loans'));
    }

    // Crear préstamo
    public function store(Request $request)
    {
        $book = Book::findOrFail($request->book_id);

        if (!$book->isAvailable()) {
            return response()->json([
                'error' => 'El libro no está disponible'
            ], 409);
        }

        $loan = Loan::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'loaned_at' => now(),
            'due_at' => now()->addDays(14),
            'status' => 'open',
        ]);

        return $loan->load(['user', 'book']);
    }

    // Marcar préstamo como devuelto
    public function returnBook(Loan $loan)
    {
        if ($loan->returned_at !== null) {
            return response()->json([
                'error' => 'El préstamo ya fue cerrado'
            ], 409);
        }

        $loan->update([
            'returned_at' => now(),
            'status' => 'returned',
        ]);

        return $loan;
    }

    // Eliminar préstamo (histórico)
    public function destroy(Loan $loan)
    {
        $loan->delete();
        return response()->noContent();
    }
}

