<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateUser;
use App\Http\Requests\ShowUser;
use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
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
}
