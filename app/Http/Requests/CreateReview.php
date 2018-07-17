<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use App\Models\Review;
use App\Rules\HasRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateReview extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create', Review::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'restaurant_id' => [
                'required',
                'exists:restaurant,id',
                Rule::unique('reviews')->where(function ($query) {
                    return $query;
                })
            ]
        ];
    }
}
