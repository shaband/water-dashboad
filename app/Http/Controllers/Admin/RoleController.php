<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Role\CreateRoleRequest;
use App\Http\Requests\Admin\Role\UpdateRoleRequest;
use App\Http\Resources\Admin\Role\RoleResource;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return RoleResource::collection(Role::query()->paginate());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return RoleResource
     */
    public function store(CreateRoleRequest $request)
    {
        DB::beginTransaction();
        $role = Role::query()->create(
            array_merge(
                $request->only('label_ar', 'label_en', 'guard_name'),
                ['name' => $request->label_en]
            )
        );
        $role->syncPermissions(array_column($request->permissions, 'id'));
        DB::commit();
        return new RoleResource($role);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return RoleResource
     */
    public function show($id)
    {

        return new RoleResource(Role::with('permissions')->find($id));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param int $id
     * @return RoleResource
     */
    public function update(UpdateRoleRequest $request, int $id)
    {
        DB::beginTransaction();
        $role = Role::query()->find($id);
        $role->fill(
            array_merge(
                $request->only('label_ar', 'label_en'),
                ['name' => $request->label_en]
            )
        )->save();
        $role->syncPermissions(array_column($request->permissions, 'id'));
        DB::commit();
        return new RoleResource($role);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::destroy($id);
        return response()->noContent();
    }
}
