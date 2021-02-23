<?php

namespace App\Http\Resources\Delivery;

use App\Http\Resources\CarType\CarTypeResource;
use App\Http\Resources\City\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryResource extends JsonResource
{
    public static $wrap=false;
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
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => \Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : \Storage::url($this->image),
            'car_number' => $this->car_number,
            'car_paper_image' => \Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : \Storage::url($this->car_paper_image),
            'car_type' => new CarTypeResource($this->whenLoaded('carType')),
            'city' => new CityResource($this->whenLoaded('city')),
            'car_type_id' => $this->car_type_id,
            'city_id' => $this->city_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'blocked_at' => $this->blocked_at,
            'status' => $this->status,
        ];
    }
}
