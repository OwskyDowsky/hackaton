<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstudiantesPadres extends Model
{
    use HasFactory;
    protected $fillable = [
        'padre_id',
        'estudiante_id',
    ];

    // Define las relaciones con los modelos User (padre) y User (estudiante)
    public function padre()
    {
        return $this->belongsTo(User::class, 'padre_id');
    }

    public function estudiante()
    {
        return $this->belongsTo(User::class, 'estudiante_id');
    }
}
