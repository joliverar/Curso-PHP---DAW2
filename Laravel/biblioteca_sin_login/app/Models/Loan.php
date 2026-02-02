<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    // Campos asignables masivamente
    protected $fillable = [
        'user_id','book_id','loaned_at','due_at','returned_at','status'
    ];

    // Casts para convertir automáticamente las fechas a instancias de Carbon
    protected $casts = [
        'loaned_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // Relaciones Eloquent
    // Un préstamo pertenece a un usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    // Un préstamo pertenece a un libro
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

}
