<?php

namespace App\Http\Requests\Admin\Invoice;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceUpdateRequest extends FormRequest
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
            'code' => ['string'],
            'agent_id' => ['required', 'integer', 'exists:agents,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'address_id' => ['integer', 'exists:addresses,id'],
            'delivering_date' => ['date'],
            'delivering_time' => [''],
            'user_address_id' => ['integer', 'exists:user_addresses,id'],
            'delivery_id' => ['integer', 'exists:deliveries,id'],
            'agent_accepted_at' => [''],
            'delivert_accepted_at' => [''],
            'canceled_by' => ['string'],
            'canceled_at' => [''],
            'payment_type' => ['required', 'string'],
            'promocode_id' => ['integer', 'exists:promocodes,id'],
            'is_charity' => ['required', 'integer', 'gt:0'],
            'status' => ['required', 'in:new,delivery_approval,delivering,finished,canceled'],
            'notes' => ['string'],
            'price' => ['required', 'numeric', 'between:-9999.999999,9999.999999'],
            'delivery_price' => ['required', 'numeric', 'between:-9999.999999,9999.999999'],
            'descount' => ['required', 'numeric', 'between:-9999.999999,9999.999999'],
            'tax' => ['required', 'numeric', 'between:-9999.999999,9999.999999'],
            'lat' => ['string'],
            'lng' => ['string'],
        ];
    }
}
