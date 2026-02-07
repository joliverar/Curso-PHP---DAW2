<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@biblioteca.com',
            'password' => Hash::make('uw872301'),
            'role' => 'admin',
        ]);

        // Bibliotecario
        User::create([
            'name' => 'Bibliotecario',
            'email' => 'bibliotecario@biblioteca.com',
            'password' => Hash::make('uw872301'),
            'role' => 'librarian',
        ]);

        // Socio
        User::create([
            'name' => 'Socio',
            'email' => 'socio@biblioteca.com',
            'password' => Hash::make('uw872301'),
            'role' => 'user',
        ]);
    }
}
