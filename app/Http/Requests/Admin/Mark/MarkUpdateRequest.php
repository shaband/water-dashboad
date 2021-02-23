<?php

namespace App\Http\Requests\Admin\Mark;

use Illuminate\Foundation\Http\FormRequest;

class MarkUpdateRequest extends FormRequest
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
        return [
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'blocked_at' => [''],
            'image' => ['string'],
        ];
    }
}
