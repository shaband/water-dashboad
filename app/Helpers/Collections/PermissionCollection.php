<?php


namespace App\Helpers\Collections;


use App\Http\Resources\Admin\Permission\PermissionResource;
use Illuminate\Database\Eloquent\Collection;

class PermissionCollection extends Collection
{

    /**
     * group All permission by group name
     * @return PermissionCollection|\Illuminate\Support\Collection
     */
    public  function toGroups(){

       return $this->groupBy('group_name')->map( fn($permissions, $group_name) => [
                'group' => __($group_name),
                'permission' => PermissionResource::collection($permissions),
            ])->values();
    }
}
