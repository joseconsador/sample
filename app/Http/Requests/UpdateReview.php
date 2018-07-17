<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use App\Models\Review;
use App\Rules\HasPermission;
use App\Rules\HasRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReview extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('review'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['sometimes', 'required', 'integer', 'exists:users,id', new HasPermission('review-restaurant')],
            'rating' => ['sometimes', 'required', 'between:1,5'],
            'comment' => ['sometimes', 'required']
        ];
    }
}
