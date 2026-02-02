<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    /**
     * Mostrar listado de préstamos paginados.
     * Carga relaciones user y book para evitar N+1.
     */
    public function index()
    {
        $loans = Loan::query()
            ->with(['user', 'book']) // eager load
            ->latest()
            ->paginate(10);

        return view('loans.index', compact('loans'));
    }

    /**
     * Formulario de creación de préstamo.
     * - Carga usuarios (id, name, email)
     * - Carga solo libros disponibles (sin préstamos abiertos)
     */
    public function create()
    {
        $users = User::query()
            ->orderBy('name')
            ->get(['id', 'name', 'email']);

        // Seleccionar únicamente libros que no tengan un préstamo abierto
        $books = Book::query()
            // consideramos "abierto" un préstamo cuyo returned_at es NULL
            ->whereDoesntHave('loans', function ($q) {
                $q->whereNull('returned_at');
            })
            ->orderBy('title')
            ->get();

        return view('loans.create', compact('users', 'books'));
    }

    /**
     * Almacenar nuevo préstamo.
     * - Valida entrada
     * - Realiza la creación dentro de una transacción para evitar condiciones de carrera
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'due_at' => ['required', 'date', 'after:now'],
        ]);

        // Transacción para garantizar consistencia y evitar race conditions
        DB::transaction(function () use ($data) {

            // Bloquear fila del libro para evitar que dos peticiones simultáneas lo tomen
            Book::query()
                ->whereKey($data['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Verificar de nuevo si existe un préstamo abierto para ese libro
            $openExists = Loan::query()
                ->where('book_id', $data['book_id'])
                // un préstamo abierto es el que no tiene returned_at
                ->whereNull('returned_at')
                ->lockForUpdate() // bloquear también la consulta de préstamos relacionados
                ->exists();

            if ($openExists) {
                // Abortar con código 422 si ya está prestado
                abort(422, 'Ese libro ya está prestado actualmente.');
            }

            // Crear el préstamo con marcas temporales y estado inicial
            Loan::create([
                'user_id' => $data['user_id'],
                'book_id' => $data['book_id'],
                'loaned_at' => now(),
                'due_at' => $data['due_at'],
                'returned_at' => null,
                'status' => 'abierto',
                'is_open' => true,
            ]);
        });

        return redirect()
            ->route('loans.index')
            ->with('message', 'Préstamo creado');
    }

    /**
     * Mostrar detalle de un préstamo.
     * Route-model binding inyecta Loan y se cargan relaciones necesarias.
     */
    public function show(Loan $loan)
    {
        $loan->load(['user', 'book']);
        return view('loans.show', compact('loan'));
    }

    /**
     * Marcar un préstamo como devuelto.
     * - Comprueba que no esté ya devuelto
     * - Actualiza returned_at, status e is_open
     */
    public function return(Loan $loan)
    {
        // Si ya está cerrado o tiene returned_at, no hacemos nada
        if ($loan->is_open === false || $loan->returned_at !== null) {
            return redirect()
                ->route('loans.show', $loan)
                ->with('message', 'Ya estaba devuelto');
        }

        // Actualizar estado a devuelto
        $loan->update([
            'returned_at' => now(),
            'status' => 'devuelto',
            'is_open' => false,
        ]);

        return redirect()
            ->route('loans.show', $loan)
            ->with('message', 'Préstamo devuelto');
    }
}
