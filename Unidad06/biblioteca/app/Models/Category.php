<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    // Campos asignables
    protected $fillable = ['name', 'slug'];

    // Relación muchos a muchos con Book
    // Una categoría puede tener muchos libros
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)
                    ->withTimestamps();
    }
}
