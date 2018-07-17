<?php

namespace App\Http\Resources\Review;

use App\Http\Resources\User\UserResource;
use App\Models\Review;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewCollection extends ResourceCollection
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function ($review) use ($request) {
                return (new ReviewResource($review))->toArray($request);
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
                (new Review())->getExportableRelations()
            );

            if (in_array('user', $includes)) {
                $included['users'] = $this->collection->pluck('user')->unique()->values()->map(function ($user) {
                    return new UserResource($user);
                });
            }
        };

        return ['include' => $included];
    }
}
