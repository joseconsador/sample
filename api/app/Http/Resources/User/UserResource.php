<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'type' => 'user',
            'id' => $this->resource->getKey(),
            'attributes' => [
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
                'roles' => $this->whenLoaded('roles', function () {
                    return new RoleCollection($this->roles);
                })
            ],
            'links' => [
                'self' => route('api::users::show', ['user' => $this->id]),
            ]
        ];
    }
}
