<?php

namespace App\Http\Requests\Admin\Delivery;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryUpdateRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:deliveries,email,' . $this->delivery->id],
            'phone' => ['required', 'string', 'unique:deliveries,phone,' . $this->delivery->id],
            'image' => ['nullable', 'string'],
            'car_number' => ['required', 'string'],
            'car_paper_image' => ['nullable', 'string'],
            'car_type_id' => ['required', 'integer', 'exists:car_types,id'],
            'city_id' => ['integer', 'exists:cities,id'],
            //   'lat' => ['string'],
            //  'lng' => ['string'],
            //   'blocked_at' => [''],
            'status' => ['required', 'in:pending,accepted,refused'],
        ];
    }
}
