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
        Schema::create('estudiantes_asistencias', function (Blueprint $table) {
            $table->id(); // ID único para cada registro
            $table->foreignId('curso_id')->constrained('cursos'); // Relación con la tabla 'cursos', clave foránea
            $table->foreignId('estudiante_id')->constrained('users'); // Relación con la tabla 'estudiantes', clave foránea
            $table->foreignId('dia_id')->constrained('dias_asistencias');
            $table->string('asistencia'); 
            $table->timestamps(); // Para las columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes_asistencias');
    }
};
