<?php

namespace App\Http\Resources\Restaurant;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RestaurantCollection extends ResourceCollection
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($restaurant) use ($request) {
                return (new RestaurantResource($restaurant))->toArray($request);
            })
        ];
    }

    public function with($request)
    {
        return [
            'included' => [
                'users' => $this->collection->pluck('owner')->unique()->values()->map(function ($user) {
                        return new UserResource($user);
                })
            ]
        ];
    }
}
