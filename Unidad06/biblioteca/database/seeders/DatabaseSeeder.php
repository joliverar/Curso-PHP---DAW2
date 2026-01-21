<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'educantabria@example.com',
            'password' => Hash::make('password'),
        ]);

        // Ejecutar seeders
        $this->call([
            AuthorsTableSeeder::class,
            CategoriesTableSeeder::class,
            BooksTableSeeder::class,
            LoansTableSeeder::class,
        ]);
    }
}

