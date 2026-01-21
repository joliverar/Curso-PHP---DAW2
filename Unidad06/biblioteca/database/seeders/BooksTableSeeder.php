<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BooksTableSeeder extends Seeder
{
    public function run(): void
    {
        $book1 = Book::create([
            'title' => 'To Kill a Mockingbird',
            'isbn' => '978-0-06-112008-4',
            'published_year' => 1960,
            'author_id' => 1,
        ]);

        $book1->categories()->sync([2]); // Clásicos

        $book2 = Book::create([
            'title' => '1984',
            'isbn' => '978-0-452-28423-4',
            'published_year' => 1949,
            'author_id' => 2,
        ]);

        $book2->categories()->sync([1, 2]); // Ciencia ficción + Clásicos

        $book3 = Book::create([
            'title' => 'Harry Potter y la piedra filosofal',
            'isbn' => '978-0-7475-3269-9',
            'published_year' => 1997,
            'author_id' => 3,
        ]);

        $book3->categories()->sync([3]); // Fantasía
    }
}
