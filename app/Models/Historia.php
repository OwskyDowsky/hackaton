<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historia extends Model
{
    use HasFactory;

    protected $table = 'historias';

    protected $fillable = [
        'nombre',
        'archivo_json', // nombre del json que se genera
    ];

    public static function rutaPythonScripts()
    {
        return base_path('python_scripts');
    }

    public function pathCompleto()
    {
        return self::rutaPythonScripts() . '/' . $this->archivo_json;
    }
}
