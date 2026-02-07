<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * SOCIO: ver mis préstamos
     */
    public function index()
    {
        $loans = Loan::with('book')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return view('loans.index', compact('loans'));
    }

    /**
     * SOCIO: formulario solicitar préstamo
     */
    public function create()
    {
        $books = Book::where('is_available', true)->get();
        return view('loans.create', compact('books'));
    }

    /**
     * SOCIO: guardar solicitud
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        $user = Auth::user();

        // Regla 1: libro disponible
        $book = Book::findOrFail($request->book_id);
        if (!$book->is_available) {
            return back()->withErrors('El libro no está disponible.');
        }

        // Regla 2: máximo 3 préstamos activos
        $activeLoans = Loan::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->count();

        if ($activeLoans >= 3) {
            return back()->withErrors('Has alcanzado el máximo de préstamos activos.');
        }

        // Regla 3: no tener préstamos vencidos
        $overdue = Loan::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('due_date', '<', now())
            ->exists();

        if ($overdue) {
            return back()->withErrors('Tienes préstamos vencidos sin devolver.');
        }

        Loan::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'status' => 'pending',
        ]);

        return redirect()
            ->route('loans.index')
            ->with('success', 'Solicitud enviada. Pendiente de aprobación.');
    }

    /**
     * BIBLIOTECARIO / ADMIN: ver todos los préstamos
     */
    public function indexAll()
    {
        $loans = Loan::with(['user', 'book', 'librarian'])
            ->orderByDesc('created_at')
            ->get();

        return view('loans.index_all', compact('loans'));
    }

    /**
     * Aprobar préstamo
     */
    public function approve($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'status' => 'approved',
            'loan_date' => now(),
            'due_date' => now()->addDays(15),
            'librarian_id' => Auth::id(),
        ]);

        $loan->book->update(['is_available' => false]);

        return back()->with('success', 'Préstamo aprobado.');
    }

    /**
     * Rechazar préstamo
     */
    public function reject($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'status' => 'rejected',
            'librarian_id' => Auth::id(),
        ]);

        return back()->with('success', 'Préstamo rechazado.');
    }

    /**
     * Marcar como devuelto
     */
    public function markAsReturned($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        $loan->book->update(['is_available' => true]);

        return back()->with('success', 'Libro devuelto correctamente.');
    }
}
