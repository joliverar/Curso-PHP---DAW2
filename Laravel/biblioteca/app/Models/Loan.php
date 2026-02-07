<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = ['book_id', 'user_name', 'loan_date', 'return_date'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
