<?php

namespace App\Http\Resources\Restaurant;

use App\Http\Resources\User\UserResource;
use App\Models\Restaurant;
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

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        $included = [];

        if ($request->has('include')) {
            $includes = array_intersect(
                explode(',', $request->query('include')),
                (new Restaurant())->getExportableRelations()
            );

            if (in_array('owner', $includes)) {
                $included['owners'] = $this->collection->pluck('owner')->unique()->values()->map(function ($user) {
                    return new UserResource($user);
                });
            }
        };

        return ['include' => $included];
    }
}
