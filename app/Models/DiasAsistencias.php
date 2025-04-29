<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasAsistencias extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha',
        'curso_id',
    ];

    public function curso()
    {
        return $this->belongsTo(Cursos::class, 'curso_id');
    }
}
