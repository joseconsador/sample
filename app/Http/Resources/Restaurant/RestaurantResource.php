<?php

namespace App\Http\Resources\Restaurant;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * The restaurant instance.
     *
     * @var \App\Models\Restaurant
     */
    public $resource;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'type' => 'restaurant',
            'id' => (string) $this->resource->getKey(),
            'attributes' => [
                'name' => $this->name,
                'owner_id' => $this->owner_id,
                'average_rating' => $this->resource->getAverageRating(),
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
            ],
            'relationships' => [
                'owner' => [
                    'type' => 'user',
                    'id' => $this->resource->owner_id
                ]
            ],
            'links' => [
                'self' => route('api::restaurant::show', ['restaurant' => $this->resource->getKey()])
            ]
        ];
    }

    public function with($request)
    {
        return [
            'included' => $this->when(
                $this->resource->relationLoaded('owner'),
                [
                    new UserResource($this->resource->owner)
                ]
            )
        ];
    }
}
