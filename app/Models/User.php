<?php

namespace App\Models;

use App\Models\Presenters\UserPresenter;
use App\Models\Traits\HasHashedMediaTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use HasHashedMediaTrait;
    use UserPresenter;

    protected $guarded = [
        'id',
        'updated_at',
        '_token',
        '_method',
        'password_confirmation',
    ];

    protected $dates = [
        'deleted_at',
        'date_of_birth',
        'email_verified_at',
    ];

    protected $fillable = [
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'fecha_nacimiento',
        'name',
        'email',
        'password',
        'celular',
        'genero',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function cursos()
    {
        return $this->belongsToMany(Cursos::class, 'curso_user'); // Ajusta el nombre de la tabla pivote si es necesario
    }

    public function cegueras()
    {
        return $this->hasMany(CeguerasEstudiantes::class, 'usuario_id');
    }
}
