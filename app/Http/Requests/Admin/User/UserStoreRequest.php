<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'phone' => ['required', 'string', 'unique:admins,phone'],
            'image' => ['nullable', 'string'],
            'city_id'=>['required','integer','exists:cities,id']
        ];
    }
}
