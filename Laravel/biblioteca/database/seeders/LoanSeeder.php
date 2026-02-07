<?php

namespace Database\Seeders;

use App\Models\Loan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Loan::create(['book_id' => 1, 'user_name' => 'Gloria', 'loan_date' => now(), 'return_date' => now()]);
        Loan::create(['book_id' => 4, 'user_name' => 'Raul', 'loan_date' => now(), 'return_date' => now()]);
        Loan::create(['book_id' => 2, 'user_name' => 'Elvira', 'loan_date' => now(), 'return_date' => now()]);
        Loan::create(['book_id' => 3, 'user_name' => 'Milan', 'loan_date' => now(), 'return_date' => now()]);
    }
}
