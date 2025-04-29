<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriasProfesores extends Model
{
    use HasFactory;
    protected $fillable = ['usuario_id', 'materia'];

    // Relación con el modelo User (uno a muchos, si un usuario tiene muchos grados)
    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }
}
