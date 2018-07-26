<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use App\Models\Review;
use App\Rules\HasPermission;
use App\Rules\HasRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReplyReview extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('reply', $this->route('review'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reply' => ['required']
        ];
    }
}
