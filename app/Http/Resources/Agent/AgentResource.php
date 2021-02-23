<?php

namespace App\Http\Resources\Agent;

use App\Http\Resources\City\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AgentResource
 * @package App\Http\Resources\Agent
 * @mixin  \App\Models\Agent
 */
class AgentResource extends JsonResource
{
    public static $wrap = false;

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
            'blocked_at' => $this->blocked_at,
            'city_id' => $this->city_id,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'city' => new CityResource($this->whenLoaded('city')),
            'cities' => CityResource::collection($this->whenLoaded('cities')),
        ];


    }
}
