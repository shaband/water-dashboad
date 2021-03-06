<?php

namespace App\Http\Requests\Admin\Chat;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
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
            'message' => ['nullable', 'string'],
//            'chat_id' => ['required', 'integer', 'exists:chats,id'],
//            'sender' => ['nullable', 'required'],
            'file' => ['nullable', 'string'],
            'file_ext' => ['nullable', 'string'],
        ];
    }
}
