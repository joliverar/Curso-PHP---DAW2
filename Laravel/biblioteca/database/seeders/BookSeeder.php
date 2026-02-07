<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Book::create(['title' => 'El pais de los sueños', 'year' => '2023', 'author_id' => 1, 'category_id' => 1, 'available' => false]);
        Book::create(['title' => 'La majia esta aqui', 'year' => '2023', 'author_id' => 1, 'category_id' => 1, 'available' => false]);
        Book::create(['title' => 'El mejor lugar', 'year' => '2023', 'author_id' => 1, 'category_id' => 1, 'available' => false]);
        Book::create(['title' => 'Sonido del momento', 'year' => '2023', 'author_id' => 1, 'category_id' => 1, 'available' => false]);
    }
}
