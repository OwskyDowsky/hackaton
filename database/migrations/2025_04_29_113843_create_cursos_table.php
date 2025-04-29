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
        Schema::create('cursos', function (Blueprint $table) {
            $table->id(); // ID único para cada curso
            $table->string('nombre'); // Nombre del curso
            $table->string('grado'); // Grado al que pertenece el curso (puede ser un texto)
            $table->integer('capacidad'); // Capacidad del curso (número de estudiantes que puede tener)
            $table->string('turno'); // Turno del curso (puede ser mañana, tarde, etc.)
            $table->timestamps(); // Para las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cursos');
    }
};
