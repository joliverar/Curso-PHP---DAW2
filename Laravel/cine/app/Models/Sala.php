<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    //
    protected $fillable = ['nombre', 'aforo'];

    public function proyecciones()
    {
        return $this->hasMany(Proyeccion::class);
    }
}
