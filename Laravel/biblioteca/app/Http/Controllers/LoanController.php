<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = Loan::with('book')->get();
        return view('loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::where('available', true)->get();
        return view('loans.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_name' => 'required|string|max:255',
        ]);
        $book = Book::findOrFail($request->book_id);

        if (!$book->available) {
            return redirect::back()
                ->with('error', 'el libro no esta disponible');
        }
        Loan::create([
            'book_id' => $book->id,
            'user_name' => $request->user_name,
            'loan_date' => now(),
        ]);
        // Marcar libro como no disponible
        $book->update(['available' => false]);

        return redirect::route('loans.index')
            ->with('success', 'prestamo registrado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function return(Loan $loan)
    {
        if ($loan->return_date !== null) {
            return redirect::back()
                ->with('error', 'El prestamo ya fue devuelto');
        }

        $loan->update([
            'return_date' => now()
        ]);

        $loan->book->update(['available' => true]);
        return redirect::route('loans.index')
            ->with('succes', 'libro devuelto correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        if ($loan->return_date === null) {
            $loan->book->update(['available' => true]);
        }

        $loan->delete();
        return redirect::route('loans.index')
            ->with('success', 'Prestamo eliminado');
    }
}
