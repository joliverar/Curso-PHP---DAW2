<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Ciencia Ficción',
                'slug' => 'ciencia-ficcion',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Clásicos',
                'slug' => 'clasicos',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fantasía',
                'slug' => 'fantasia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


