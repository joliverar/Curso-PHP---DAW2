<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('authors')->insert([
            [
                'name' => 'Harper Lee',
                'country' => 'Estados Unidos',
                'birth_date' => '1926-04-28',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'George Orwell',
                'country' => 'Reino Unido',
                'birth_date' => '1903-06-25',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'J.K. Rowling',
                'country' => 'Reino Unido',
                'birth_date' => '1965-07-31',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

