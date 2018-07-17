<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ApiResponseException;
use App\Http\Requests\CreateRestaurant;
use App\Http\Requests\UpdateRestaurant;
use App\Http\Resources\Restaurant\RestaurantCollection;
use App\Http\Resources\Restaurant\RestaurantResource;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantsController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return RestaurantCollection
     */
    public function index(Request $request)
    {
        /**
         * @var $collection Collection
         */
        $collection = Restaurant::forUser(Auth::user())
                                    ->paginate($request->query('per_page'))
                                    ->appends($request->query->all());

        if ($request->has('include')) {
            $collection->load(explode(',', $request->query('include')));
        };


        return new RestaurantCollection($collection);
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
        $restaurant->fill($request->only($restaurant->getFillable()));

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
     * @param Request $request
     * @param  \App\Models\Restaurant $restaurant
     * @return RestaurantResource
     */
    public function show(Request $request, Restaurant $restaurant)
    {
        if ($request->has('include')) {
            $restaurant->load(explode(',', $request->query('include')));
        };

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
        $fields = $request->all();

        /**
         * @var $user User
         */
        $user = Auth::user();
        if (!$user->hasRole('admin')) {
            $fields['owner_id'] = $user->getKey();
        }

        $restaurant->fill($fields);
        $restaurant->owner_id = $fields['owner_id'];
        $restaurant->save();

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
