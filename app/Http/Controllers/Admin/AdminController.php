<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Admin\AdminStoreRequest;
use App\Http\Requests\Admin\Admin\AdminUpdateRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        return AdminResource::collection(Admin::with('roles')->paginate());
    }

    /**
     * @param \App\Http\Requests\Admin\Admin\AdminStoreRequest $request
     * @return AdminResource
     */
    public function store(AdminStoreRequest $request)
    {
        $admin = Admin::create($request->validated());
        $admin->assignRole($request->role_id);
        return new AdminResource($admin);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $admin
     * @return \App\Http\Resources\Admin\AdminResource
     */
    public function show(Request $request, Admin $admin)
    {
        return new AdminResource($admin->load('roles'));
    }

    /**
     * @param \App\Http\Requests\Admin\Admin\AdminUpdateRequest $request
     * @param \App\Models\Admin $admin
     * @return \App\Http\Resources\Admin\AdminResource
     */
    public function update(AdminUpdateRequest $request, Admin $admin)
    {
        $admin->update($request->validated());
        $admin->syncRoles($request->role_id);
        return new AdminResource($admin);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Admin $admin)
    {
        $admin->delete();

        return response()->noContent();
    }
}
