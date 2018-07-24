<?php

namespace App\Http\Controllers\API;

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
                        ->withAverageRating()
                        ->orderBy('average_rating', 'desc')
                        ->paginate($request->query('per_page'))
                        ->appends($request->query->all());

        return new RestaurantCollection($collection);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateRestaurant $request
     * @return \Illuminate\Http\JsonResponse
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
            $relations = array_intersect(
                explode(',', $request->query('include')),
                $restaurant->getExportableRelations()
            );
            $restaurant->load($relations);
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
     * @param UpdateRestaurant $request
     * @param  \App\Models\Restaurant $restaurant
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy(UpdateRestaurant $request, Restaurant $restaurant)
    {
        $restaurant->delete();

        return response('ok');
    }
}
