<?php

namespace Database\Seeders;

use App\Models\Proyeccion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProyeccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Proyeccion::create(['pelicula_id' => 1, 'sala_id' => 1, 'fecha_hora' => now()]);
        Proyeccion::create(['pelicula_id' => 3, 'sala_id' => 2, 'fecha_hora' => now()]);
    }
}
