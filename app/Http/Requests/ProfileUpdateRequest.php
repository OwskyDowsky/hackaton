<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
        // Let's get the route param by name to get the User object value
        $user = request()->route('user');

        return [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users,email,' . $user->id,
            'apellido_paterno' => 'required|string|max:255' . $user->id,
            'apellido_materno' => 'required|string|max:255' . $user->id,
            'ci' => 'required|integer|unique:users,ci,' . $user->id,
            'fecha_nacimiento' => 'required|date',
        ];
    }
}
