<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowUser extends FormRequest
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
    public function rules() {
        return [];
    }
}
