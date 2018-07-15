<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Restaurant as RestaurantResource;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
        return new ResourceCollection(Restaurant::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
