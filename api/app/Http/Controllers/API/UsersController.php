<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\ShowUserRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseAPIController {

    /**
     * Returns the currently logged in user.
     *
     * @return UserResource
     */
    public function me() {
        $user = User::findOrFail(Auth::id());
        $user->load('roles');
        return new UserResource($user);
    }

    /**
     * Return a user by ID.
     *
     * @param ShowUserRequest $request
     * @param User $user
     * @return UserResource
     */
    public function show(ShowUserRequest $request, User $user) {
        $user->load('roles');
        return new UserResource($user);
    }
}