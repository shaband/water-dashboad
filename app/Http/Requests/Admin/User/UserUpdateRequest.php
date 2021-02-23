<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'password' => ['nullable', 'confirmed'],
            'email' => ['required', 'email', 'unique:admins,email,' . $this->user->id],
            'phone' => ['required', 'string', 'unique:admins,phone,' . $this->user->id],
            'image' => ['nullable', 'string'],
            'city_id' => ['required', 'integer', 'exists:cities,id']

        ];
    }
}
