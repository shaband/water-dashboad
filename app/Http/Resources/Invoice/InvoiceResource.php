<?php

namespace App\Http\Resources\Invoice;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class InvoiceResource
 * @package App\Http\Resources\Invoice
 * @mixin \App\Models\Invoice
 */
class InvoiceResource extends JsonResource
{
    public static $wrap=false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'agent_id' => $this->agent_id,
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'delivering_date' => $this->delivering_date,
            'delivering_time' => $this->delivering_time,
            'user_address_id' => $this->user_address_id,
            'delivery_id' => $this->delivery_id,
            'agent_accepted_at' => $this->agent_accepted_at,
            'delivery_accepted_at' => $this->delivert_accepted_at,
            'canceled_by' => $this->canceled_by,
            'canceled_at' => $this->canceled_at,
            'payment_type' => $this->payment_type,
            'promocode_id' => $this->promocode_id,
            'is_charity' => $this->is_charity,
            'status' => $this->status,
            'notes' => $this->notes,
            'price' => $this->price,
            'delivery_price' => $this->delivery_price,
            'discount' => $this->discount,
            'tax' => $this->tax,
            'lat' => $this->lat,
            'lng' => $this->lng,
            //relationships
            'user'=>new UserResource($this->whenLoaded('user')),
            'promocode'=>new UserResource($this->whenLoaded('promocode')),
            'agent'=>new UserResource($this->whenLoaded('agent')),
            'delivery'=>new UserResource($this->whenLoaded('agent')),
            'products'=>InvoiceProductResource::collection( $this->whenLoaded('invoiceProducts'))
            ];
    }
}
