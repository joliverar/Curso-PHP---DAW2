<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LoansTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('loans')->insert([
            [
                'user_id' => 1,
                'book_id' => 1,
                'loaned_at' => now()->subDays(3),
                'due_at' => now()->addDays(7),
                'returned_at' => null,
                'status' => 'open',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

