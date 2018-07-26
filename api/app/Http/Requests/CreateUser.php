<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUser extends FormRequest
{
    /**
     * Whether the current user can access this resource.
     *
     * @return boolean
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Validation rules for this request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:6'],
            'role' => ['required',  Rule::in(['user', 'owner'])]
        ];
    }
}
