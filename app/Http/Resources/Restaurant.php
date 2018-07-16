<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\Resource;

class Restaurant extends JsonResource
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
        return array_merge(parent::toArray($request), [
            'owner' => new Resource($this->whenLoaded('owner')),
            'average_rating' => $this->resource->getAverageRating()
        ]);
    }
}
