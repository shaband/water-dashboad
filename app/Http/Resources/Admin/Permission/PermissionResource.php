<?php

namespace App\Http\Resources\Admin\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class PermissionResource
 * @package App\Http\Resources\Admin\Permission
 * @mixin \App\Models\Permission
 */
class PermissionResource extends JsonResource
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
        ];
    }
}
