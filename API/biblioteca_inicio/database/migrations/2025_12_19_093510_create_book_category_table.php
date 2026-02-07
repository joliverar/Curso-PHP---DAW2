<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book_category', function (Blueprint $table) {

            //Tabla Pivote  Relación Muchos a Muchos
            //Un libro puede tener muchas categorías
            //Una categoría puede tener muchos libros
            $table->id();
            $table->timestamps();
            // Definición de claves foráneas
            $table->foreignId('book_id')
            ->constrained('books')
            ->cascadeOnDelete();
            $table->foreignId('category_id')
            ->constrained('categories')
            ->cascadeOnDelete();
            // Índice único para evitar duplicados
            $table->unique(['book_id', 'category_id']);
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_category');
    }
};
