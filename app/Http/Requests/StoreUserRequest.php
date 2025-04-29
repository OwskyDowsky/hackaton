<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',  // Mínimo 3 caracteres
            'apellido_paterno' => 'required|string|min:3|max:255',  // Mínimo 3 caracteres
            'apellido_materno' => 'required|string|min:3|max:255',  // Mínimo 3 caracteres
            'ci' => 'required|digits:8|integer',  // Exactamente 8 dígitos
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:' . Carbon::now()->toDateString(),  // La fecha debe ser antes del día de hoy
            ],
            'email' => 'required|email:rfc,dns|unique:users,email',  // Email único
            'password' => 'required|string|min:6',  // Contraseña mínima de 6 caracteres
            'celular' => 'required|digits:8|integer',
            'genero' => 'required',
        ];
    }
}
