<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['comment', 'restaurant_id', 'rating'];

    /**
     * Returns the restaurant for this review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id');
    }

    /**
     * Return the user that added the review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scopes a query to empty replies.
     *
     * @param Builder $query
     * @return mixed
     */
    public function scopeWithPendingReplies(Builder $query)
    {
        return $query->where('reply', '=', '')->orWhereNull('reply');
    }
}
