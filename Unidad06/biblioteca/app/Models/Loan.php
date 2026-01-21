<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    // Campos asignables masivamente
    protected $fillable = [
        'user_id',
        'book_id',
        'loaned_at',
        'due_at',
        'returned_at',
        'status'
    ];

    // Casts de fechas a Carbon
    protected $casts = [
        'loaned_at'  => 'date',
        'due_at'     => 'date',
        'returned_at'=> 'date',
    ];

    // Relación muchos a uno con User
    // Un préstamo pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a uno con Book
    // Un préstamo pertenece a un libro
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    // Método de ayuda: comprobar si el préstamo está abierto
    public function isOpen(): bool
    {
        return $this->returned_at === null;
    }
}
