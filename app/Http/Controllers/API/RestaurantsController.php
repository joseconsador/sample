<?php

namespace App\Http\Controllers\API;

use App\Exceptions\ApiResponseException;
use App\Http\Resources\Restaurant as RestaurantResource;
use App\Models\Restaurant;
use App\Rules\HasRole;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
        return new ResourceCollection(Restaurant::forUser(Auth::user())->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @throws ApiResponseException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'owner_id' => ['required', new HasRole(['owner'])],
        ]);

        if ($validator->fails()) {
           throw new ApiResponseException($validator->errors(),Response::HTTP_UNPROCESSABLE_ENTITY);
        };

        $restaurantModel = new Restaurant();

        $restaurant = $restaurantModel->save($request->only($restaurantModel->getFillable()));

        if ($restaurant) {
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurant)
    {
        //
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
