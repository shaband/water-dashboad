<?php

namespace App\Http\Requests\Admin\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressStoreRequest extends FormRequest
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
            'address' => ['string'],
            'name_ar'=>['required','string','unique:addresses,name_ar,id'],
            'name_en'=>['required','string','unique:addresses,name_en,id'],
            'lat'=>['required'],
            'lng'=>['required'],

        ];
    }
}
