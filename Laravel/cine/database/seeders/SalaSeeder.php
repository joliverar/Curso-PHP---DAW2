<?php

namespace Database\Seeders;

use App\Models\Sala;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Sala::create(['nombre' => 'sol', 'aforo' => 20]);
        Sala::create(['nombre' => 'luna', 'aforo' => 30]);
    }
}
