<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proyeccions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelicula_id')->constrained()->onDelete('cascade');
            $table->foreignId('sala_id')->constrained()->onDelete('cascade');
            $table->dateTime('fecha_hora');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyeccions');
    }
};
