<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

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
        $user = [
            'type' => 'user',
            'id' => $this->resource->getKey(),
            'attributes' => [
                'name' => $this->name,
                'roles' => new RoleCollection($this->roles),
            ],
            'links' => [
                'self' => route('api::users::show', ['user' => $this->id]),
            ]
        ];

        if (Auth::user()->hasRole('admin')) {
            $user['attributes'] = array_merge([
                'email' => $this->email,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
            ], $user['attributes']);
        }

        return $user;
    }
}
