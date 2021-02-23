<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\UserStoreRequest;
use App\Http\Requests\Admin\User\UserUpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {

        return UserResource::collection(User::paginate());
    }

    /**
     * @param \App\Http\Requests\Admin\User\UserStoreRequest $request
     * @return UserResource
     */
    public function store(UserStoreRequest $request)
    {
        $user = User::create($request->validated());
        return new UserResource($user);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \App\Http\Resources\User\UserResource
     */
    public function show(Request $request, User $user)
    {
        return new UserResource($user);
    }

    /**
     * @param \App\Http\Requests\Admin\User\UserUpdateRequest $request
     * @param \App\Models\User $user
     * @return \App\Http\Resources\User\UserResource
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->noContent();
    }

    /**
     * @param Request $request
     * @param User $user
     * @return UserResource
     */
    public function block(Request $request, User $user)
    {
        $user->toggleBlock();
        return new UserResource($user);
    }

}
