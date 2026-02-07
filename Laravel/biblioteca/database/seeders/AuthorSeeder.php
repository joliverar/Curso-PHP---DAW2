<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Author::create(['name' => 'Jino', 'country' => 'Peru']);
        Author::create(['name' => 'Milan', 'country' => 'Peru']);
        Author::create(['name' => 'Ronald', 'country' => 'Peru']);
        Author::create(['name' => 'Alana', 'country' => 'Peru']);
    }
}
