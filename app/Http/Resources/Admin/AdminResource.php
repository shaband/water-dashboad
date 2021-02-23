<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\Admin\Permission\PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class AdminResource
 * @package App\Http\Resources\Admin
 * @mixin \App\Models\Admin
 */
class AdminResource extends JsonResource
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
//        $user->getAllPermissions();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => \Str::startsWith($this->image, ['http://', 'https://']) ? $this->image : \Storage::url($this->image),
            'role_id' => $this->when($this->resource->relationLoaded('roles'), function () {
                return optional($this->roles->first())->id;
            }),
            'role_name' => $this->when($this->resource->relationLoaded('roles'), function () {
                return optional($this->roles->first())->label_ar;
            }),
            'permissions' => $this->getAllPermissions()->pluck('name'),


        ];
    }
}
