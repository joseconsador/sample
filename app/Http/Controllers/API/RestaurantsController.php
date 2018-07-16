<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ApiResponseException;
use App\Http\Requests\CreateRestaurant;
use App\Http\Requests\UpdateRestaurant;
use App\Http\Resources\Restaurant as RestaurantResource;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class RestaurantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request)
    {
        return new ResourceCollection(Restaurant::forUser(Auth::user())
                    ->paginate($request->get('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ApiResponseException
     */
    public function store(CreateRestaurant $request)
    {
        $restaurant = new Restaurant();
        $restaurant->save($request->only($restaurant->getFillable()));

        /**
         * @var $user User
         */
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            $restaurant->owner_id = $user->getKey();
        }

        $restaurant->save();

        return (new RestaurantResource($restaurant))
                ->response()
                ->header('Location', route('api::restaurant::show', ['id' => $restaurant->getKey()]));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return RestaurantResource
     */
    public function show(Restaurant $restaurant)
    {
        return new RestaurantResource($restaurant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRestaurant $request
     * @param  \App\Models\Restaurant $restaurant
     * @return RestaurantResource
     */
    public function update(UpdateRestaurant $request, Restaurant $restaurant)
    {
        $fields = $request->only($restaurant->getFillable());

        /**
         * @var $user User
         */
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            $fields['owner_id'] = $user->getKey();
        }

        $restaurant->fill($fields)->save();

        return new RestaurantResource($restaurant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Restaurant $restaurant)
    {
        //
    }
}
