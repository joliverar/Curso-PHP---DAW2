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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->string('isbn')->unique();
            $table->unsignedSmallInteger('published_year')->nullable();

            //Clave foránea al autor
            $table->foreignId('author_id')
            ->constrained('authors')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

            //Índice compuesto para búsquedas frecuentes
            $table->index(['author_id', 'title']);

        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};



