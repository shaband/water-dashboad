<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Mark\MarkResource;
use App\Http\Resources\Provider\ProviderResource;
use App\Models\Provider;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProductResource
 * @package App\Http\Resources\Product
 * @mixin  \App\Models\Product
 */
class ProductResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'description_ar' => $this->description_ar,
            'description_en' => $this->description_en,
            'mark_id' => $this->mark_id,
            'provider_id'=>$this->provider_id,
            'category_id' => $this->category_id,
            'price' => $this->price,
            'is_charity' => $this->is_charity,
            'mark'=>new MarkResource($this->whenLoaded('mark')),
            'category'=>new MarkResource($this->whenLoaded('category')),
            'provider'=>new ProviderResource($this->whenLoaded('provider')),
            'image'=>\Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : \Storage::url($this->image),

        ];
    }
}
