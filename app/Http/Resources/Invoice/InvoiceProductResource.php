<?php

namespace App\Http\Resources\Invoice;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class InvoiceProductResource
 * @package App\Http\Resources\Invoice
 * @mixin \App\Models\InvoiceProduct
 */
class InvoiceProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product_name' => $this->when($this->resource->relationLoaded('product'), function () {
                return $this->product->name_ar;
            }),
            'unit_price' => $this->unit_price,
            'quantity' => $this->quantity,
            'total_price' => $this->total_price,
            'offer_id' => $this->offer_id,
        ];
    }
}
