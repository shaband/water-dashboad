<?php

namespace App\Http\Resources\Admin\Role;

use App\Helpers\Collections\PermissionCollection;
use App\Http\Resources\Admin\Permission\PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RoleResource
 * @package App\Http\Resources\Admin\Role
 * @mixin \App\Models\Role
 */
class RoleResource extends JsonResource
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
            'label_ar' => $this->label_ar,
            'label_en' => $this->label_en,
            'label' => $this->label,
            'guard_name' => $this->guard_name,
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions'))
        ];
    }
}
