<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudiantesAsistencias extends Model
{
    use HasFactory;
    protected $fillable = [
        'curso_id',
        'estudiante_id',
        'dia_id',
        'asistencia',
    ];
}
