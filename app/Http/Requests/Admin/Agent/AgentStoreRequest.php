<?php

namespace App\Http\Requests\Admin\Agent;

use Illuminate\Foundation\Http\FormRequest;

class AgentStoreRequest extends FormRequest
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
            'password' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:agents,email'],
            'phone' => ['required', 'string', 'unique:agents,phone'],
            'image' => ['required', 'string', 'max:400'],
//            'blocked_at' => [''],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'cities.*.id' => ['required', 'exists:cities,id'],

            'lat' => ['string'],
            'lng' => ['string'],
        ];
    }
}
