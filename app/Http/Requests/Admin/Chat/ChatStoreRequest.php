<?php

namespace App\Http\Requests\Admin\Chat;

use Illuminate\Foundation\Http\FormRequest;

class ChatStoreRequest extends FormRequest
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
            'id' => ['nullable', 'integer'],
            'first_id' => ['nullable', 'integer'],
            'first_type' => ['nullable', 'string', 'in:admins,users,agents,deliveries'],
            'second_id' => ['required', 'integer'],
            'second_type' => ['required', 'string', 'in:admins,users,agents,deliveries'],
            'msg.message' => ['nullable', 'string'],
            'msg.file' => ['nullable', 'string'],
        ];
    }
}
