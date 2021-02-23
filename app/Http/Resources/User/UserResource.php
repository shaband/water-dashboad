<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\Permission\PermissionResource;
use App\Http\Resources\City\CityResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AdminResource
 * @package App\Http\Resources\Admin
 * @mixin \App\Models\User
 */
class UserResource extends JsonResource
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
            'city_id' => $this->city_id,
            'blocked_at' => $this->blocked_at,
            'city' => new CityResource($this->whenLoaded('city')),
            'image' => \Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : \Storage::url($this->image),

        ];
    }
}
