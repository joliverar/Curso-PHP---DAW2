<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('authors')->insert([
            [
                'name' => 'Harper Lee',
                'created_at' => now(),
                'updated_at' => now(),
                'country' => 'American',
            ],
            [
                'name' => 'George Orwell',
                'created_at' => now(),
                'updated_at' => now(),
                'country' => 'British',
            ],
            [
                'name' => 'F. Scott Fitzgerald',
                'created_at' => now(),
                'updated_at' => now(),
                'country' => 'American',
            ],
        ]);
    }
}
