<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoleRequest extends FormRequest
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
        //  dd($this->permissions);
        return [
            'label_en' => 'required|string|unique:roles,label_en',
            'label_ar' => 'required|string|unique:roles,label_ar',
            'guard_name' => 'required|string|in:admin,agent',
            'permissions.*.id' => 'required|integer|exists:permissions,id',
        ];
    }
}
