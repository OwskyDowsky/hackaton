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
        Schema::create('estudiantes_padres', function (Blueprint $table) {
            $table->id(); // ID único para cada registro
            $table->foreignId('padre_id')->constrained('users'); // Relación con la tabla 'users' (sin eliminación en cascada)
            $table->foreignId('estudiante_id')->constrained('users');
            $table->timestamps(); // Para las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes_padres');
    }
};
