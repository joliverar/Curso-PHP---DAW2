<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('books')->insert([
            [
                'title' => 'To Kill a Mockingbird',
                'published_year' => 1960,
                'created_at' => now(),
                'updated_at' => now(),
                'author_id' => 1,
                'isbn' => '978-0-06-112008-4',
            ],
            [
                'title' => '1984',
                'published_year' => 1949,
                'created_at' => now(),
                'updated_at' => now(),
                'author_id' => 2,
                'isbn' => '978-0-452-28423-4',

            ],

        ]);
    }
}
