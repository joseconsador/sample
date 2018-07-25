<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Restaurant extends Model
{
    protected $exportableRelations = ['owner', 'reviews'];
    protected $fillable = ['name', 'description'];

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

    /**
     * Returns the average rating from cache.
     *
     * @return int|null
     */
    public function getAverageRatingAttribute()
    {
        $expiresAt = now()->addMinutes(config('cache.lifetime.average_rating'));
        return Cache::remember(
            'restaurant_' . $this->getKey() . '_average_rating',
            $expiresAt,
            function () {
                return $this->reviews()->avg('rating');
            }
        );
    }

    /**
     * Adds the average_rating value to a query.
     *
     * @param Builder $query
     * @param int|array $values
     * @return Builder|\Illuminate\Database\Query\Builder
     */
    public function scopeWithAverageRating(Builder $query, $values = NULL) {
        $query = $query
                    ->select('restaurants.*')
                    ->leftJoin('reviews', 'reviews.restaurant_id', '=', 'restaurants.id')
                    ->addSelect(DB::raw('AVG(reviews.rating) as average_rating'));

        return $query->groupBy('restaurants.id');
    }

    /**
     * Filters by rating.
     *
     * @param Builder $query
     * @param null $values
     * @return Builder
     */
    public function scopeFilterRating(Builder $query, $values=null) {
        if ($values != NULL) {
            if (is_array($values) && count($values) > 1) {
                return $query
                            ->havingRaw('AVG(reviews.rating) >= ?', [$values[0]])
                            ->havingRaw('AVG(reviews.rating) <= ?', [$values[1]]);
            } else {
                return $query->havingRaw('ROUND(AVG(reviews.rating), 2) = ?', $values);
            }
        }
    }
}
