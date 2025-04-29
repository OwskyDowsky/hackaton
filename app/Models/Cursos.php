<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'grado', 'capacidad', 'turno'];

    public function diasAsistencias()
    {
        return $this->hasMany(DiasAsistencias::class);
    }

    // En el modelo Cursos
    public function estudiantes()
    {
        return $this->belongsToMany(User::class, 'estudiantes_cursos', 'curso_id', 'usuario_id')->withTimestamps();
    }
}
