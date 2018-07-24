<?php

namespace App\Http\Resources\Review;

use App\Http\Resources\Restaurant\RestaurantResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'review',
            'id' => $this->resource->getKey(),
            'attributes' => [
                'user_id' => $this->user_id,
                'restaurant_id' => $this->restaurant_id,
                'rating' => (int) $this->rating,
                'comment' => $this->comment,
                'reply' => $this->reply,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
            ],
            'relationships' => [
                'user' => [
                    'type' => 'user',
                    'id' => $this->user_id,
                ],
                'restaurant' => [
                    'type' => 'restaurant',
                    'id' => $this->restaurant_id,
                ]
            ],
            'links' => [
                'self' => route('api::restaurant::show::reviews::show', [
                    'restaurant' => $this->restaurant_id,
                    'review' => $this->resource->getKey()
                ])
            ]
        ];
    }

    /**
     * Add the included relationships to the response.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function with($request)
    {
        $included = $this->removeMissingValues([
            $this->when($this->resource->relationLoaded('user'), function () {
                return new UserResource($this->resource->user);
            }),
            $this->when($this->resource->relationLoaded('restaurant'), function () {
                return new RestaurantResource($this->resource->restaurant);
            }),
        ]);

        return ['included' => $included];
    }
}
