<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class MyLoanController extends Controller
{
    /**
     * Mostrar la lista de préstamos del usuario autenticado.
     * - Filtra por user_id del request (usuario actual).
     * - Carga la relación 'book' para evitar N+1.
     * - Ordena por fecha (latest) y pagina (10 por página).
     */
    public function index(Request $request)
    {
        $loans = Loan::query()
            ->where('user_id', $request->user()->id) // solo préstamos del usuario actual
            ->with('book')                            // eager load de la relación book
            ->latest()                                // ordenar por created_at desc
            ->paginate(10);                           // paginación

        return view('myloans.index', compact('loans')); // renderiza la vista con los datos
    }

    /**
     * Mostrar detalle de un préstamo del usuario autenticado.
     * - Comprueba que el préstamo pertenece al usuario (abort 403 si no).
     * - Carga relación 'book' y muestra la vista de detalle.
     */
    public function show(Request $request, Loan $loan)
    {
        // Seguridad: aborta con 403 si el préstamo no pertenece al usuario actual
        abort_unless($loan->user_id === $request->user()->id, 403);

        $loan->load('book'); // cargar datos del libro asociado

        return view('myloans.show', compact('loan')); // renderiza la vista de detalle
    }
}
