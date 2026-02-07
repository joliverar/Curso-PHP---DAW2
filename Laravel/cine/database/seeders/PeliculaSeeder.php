<?php

namespace Database\Seeders;

use App\Models\Pelicula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeliculaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Pelicula::create(['titulo' => 'matrix', 'duracion' => 120]);
        Pelicula::create(['titulo' => 'inception', 'duracion' => 134]);
        Pelicula::create(['titulo' => 'Mares', 'duracion' => 157]);
    }
}
