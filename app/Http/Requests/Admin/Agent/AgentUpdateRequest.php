<?php

namespace App\Http\Requests\Admin\Agent;

use Illuminate\Foundation\Http\FormRequest;

class AgentUpdateRequest extends FormRequest
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
            'password' => ['nullable', 'string'],
            'email' => ['required', 'email', 'unique:agents,email,' . $this->agent->id],
            'phone' => ['required', 'string', 'unique:agents,phone,' . $this->agent->id],
            'image' => ['nullable', 'string', 'max:400'],
//            'blocked_at' => [''],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'cities' => ['required', 'array'],
            'cities.*id' => ['required', 'exists:cities,id'],
//            'lat' => ['string'],
//            'lng' => ['string'],
        ];
    }
}
