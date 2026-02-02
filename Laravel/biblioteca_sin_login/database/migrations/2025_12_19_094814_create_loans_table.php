<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Definición de claves foráneas
            //Usuario que realiza el préstamo: users_table
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            //Libro prestado
            $table->foreignId('book_id')
                ->constrained('books')
                ->restrictOnDelete();
            //Fechas del préstamo
            $table->date('loaned_at');
            //Fecha de vencimiento
            $table->date('due_at');
            //Fecha de devolución (puede ser nula si no se ha devuelto aún)
            $table->date('returned_at')->nullable();

            $table->string('status')->default('open'); // open | returned
            // Índice ÚNICO real: solo 1 préstamo abierto por libro
            $table->unique(['book_id', 'returned_at'], 'loans_book_open_unique');
            // Índice para optimizar consultas frecuentes
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};


