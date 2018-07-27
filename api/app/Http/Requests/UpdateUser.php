<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUser extends FormRequest
{
    /**
     * Whether the current user can access this resource.
     *
     * @return boolean
     */
    public function authorize()
    {
        return $this->user()->can('view', $this->route('user'));
    }

    /**
     * Validation rules for this request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes','required'],
            'email' => [
                'sometimes',
                'required',
                'email',
                Rule::unique('users')->ignore($this->route('user')->email, 'email')
            ],
            'password' => ['sometimes', 'required', 'confirmed', 'min:6'],
            'role' => ['sometimes', 'required',  Rule::in(['user', 'owner'])]
        ];
    }
}
