<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyeccion extends Model
{
    //
    protected $fillable = ['pelicula_id', 'sala_id', 'fecha_hora'];

    public function pelicula()
    {
        return $this->belongsTo(Pelicula::class);
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }
}
