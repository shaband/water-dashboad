<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'description_ar' => ['required', 'string'],
            'description_en' => ['required', 'string'],
            'mark_id' => ['required', 'integer', 'exists:marks,id'],
            'provider_id' => ['required', 'integer', 'exists:providers,id'],

            'category_id' => ['required', 'integer', 'exists:categories,id'],
//            'price' => ['required', 'numeric'],
            'is_charity' => ['required', 'boolean'],
            'image' => ['nullable', 'string'],
        ];
    }
}
