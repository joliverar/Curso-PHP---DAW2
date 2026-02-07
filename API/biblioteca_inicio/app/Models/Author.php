<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Book;

class Author extends Model
{
    // Campos asignables
   protected $fillable = ['name','country','birth_date'];

   // Cast para convertir birth_date a instancia de Carbon
    protected $casts = ['birth_date' => 'date'];

    // Relación uno a muchos con Book
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }

}

