<?php

namespace App\Http\Requests;

use App\Rules\HasRole;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurant extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('restaurant'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['sometimes', 'required'],
            'owner_id' => ['sometimes', 'required', new HasRole(['owner'])],
        ];
    }
}
