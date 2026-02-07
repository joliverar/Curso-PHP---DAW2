<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'librarian_id',
        'status',
        'loan_date',
        'due_date',
        'return_date',
        'notes',
    ];

    // Usuario que solicita el préstamo (socio)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Libro prestado
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // Bibliotecario que gestiona
    public function librarian()
    {
        return $this->belongsTo(User::class, 'librarian_id');
    }
}
