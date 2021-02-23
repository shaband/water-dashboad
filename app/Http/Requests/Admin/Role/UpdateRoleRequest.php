<?php

namespace App\Http\Requests\Admin\Role;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
            'label_en' => 'required|unique:roles,label_en,' . $this->role,
            'label_ar' => 'required|unique:roles,label_ar,' . $this->role,
            'guard_name' => 'required|string|in:admin,agent',
            'permissions.*.id' => 'required|integer|exists:permissions,id',
        ];
    }
}
