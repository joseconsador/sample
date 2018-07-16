<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name'];

    /**
     * Returns the App\Model\User that owns the restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Returns all the App\Models\Review instances for this restaurant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reviews()
    {
        return $this->hasMany(Review::class, 'restaurant_id', 'id');
    }

    /**
     * Scopes a query based on the passed User.
     *
     * @param $query
     * @param User $user
     * @return mixed
     */
    public function scopeForUser(Builder $query, User $user)
    {
        if ($user->hasRole(['admin', 'user'])) {
            return $query;
        }

        return $query->where('owner_id', $user->getKey());
    }
}
