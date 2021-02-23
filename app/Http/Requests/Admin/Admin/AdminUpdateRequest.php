<?php

namespace App\Http\Requests\Admin\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'password' => ['required', 'password', 'confirmed'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'phone' => ['required', 'string', 'unique:admins,phone'],
            'image' => ['nullable', 'string'],
            'role_id' => ['required', 'integer', 'exists:roles,id']

        ];
    }
}
