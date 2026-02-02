<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    // Campos asignables masivamente
    protected $fillable = ['title','isbn','published_year','author_id'];

    //  Relaciones Eloquent

    // Un libro pertenece a un autor
    //Relación uno a muchos inversa
    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    // Un libro puede pertenecer a muchas categorías
    //Relación muchos a muchos
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category')->withTimestamps();
    }

    // Un libro puede tener muchos préstamos
    //Relación uno a muchos
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    // Método para verificar si el libro está disponible (no tiene préstamos activos)
    // Un libro está disponible si no tiene préstamos sin devolver
    public function isAvailable(): bool
    {
        return !$this->loans()->whereNull('returned_at')->exists();
    }

}

