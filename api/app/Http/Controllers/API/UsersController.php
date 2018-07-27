<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateUser;
use App\Http\Requests\DeleteUser;
use App\Http\Requests\ShowUser;
use App\Http\Requests\UpdateUser;
use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends BaseAPIController
{
    /**
     * Return a listing of the resource.
     *
     * @param Request $request
     * @return UserCollection
     */
    public function index(Request $request)
    {
        return new UserCollection(User::paginate($request->query('per_page'))->appends($request->query->all()));
    }

    /**
     * Return a user by ID.
     *
     * @param ShowUser $request
     * @param User $user
     * @return UserResource
     */
    public function show(ShowUser $request, User $user)
    {
        $user->load('roles');
        return new UserResource($user);
    }

    /**
     * Get all reviews by a user.
     *
     * @param ShowUser $request
     * @param User $user
     * @return ReviewCollection
     */
    public function reviews(ShowUser $request, User $user)
    {
        return new ReviewCollection(
            $user
                ->reviews()
                ->paginate($request->query('per_page'))
                ->appends($request->query->all())
        );
    }

    /**
     * Add a new user
     *
     * @param CreateUser $request
     * @return UserResource
     */
    public function store(CreateUser $request)
    {
        $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->post('password'))
        ]);

        $user->assignRole($request->post('role'));

        return new UserResource($user);
    }

    /**
     * Update an existing user.
     *
     * @param UpdateUser $request
     * @param User $user
     * @return UserResource
     */
    public function update(UpdateUser $request, User $user)
    {
        $fields = $request->validated();
        $user->fill($fields);

        // Only admins can change a role.
        if (isset($fields['role']) && Auth::user()->hasRole('admin')) {
            $user->syncRoles($fields['role']);
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DeleteUser $request
     * @param User $user
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(DeleteUser $request, User $user)
    {
        $user->delete();

        return response('ok');
    }
}
