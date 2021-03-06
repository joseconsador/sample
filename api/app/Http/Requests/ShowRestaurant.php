<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowRestaurant extends FormRequest
{
    /**
     * @return boolean
     */
    public function authorize()
    {
        return $this->user()->can('view', $this->route('restaurant'));
    }

    public function rules()
    {
        return [];
    }
}
