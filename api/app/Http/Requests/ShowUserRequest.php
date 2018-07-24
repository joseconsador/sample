<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowUserRequest extends FormRequest
{
    /**
     * @return boolean
     */
    public function authorize() {
        return $this->user()->can('view', $this->route('user'));
    }
}