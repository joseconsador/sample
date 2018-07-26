<?php

namespace App\Observers;

use App\Models\Review;
use Illuminate\Support\Facades\Cache;

class ReviewObserver
{
    /**
     * Handle the review "updated" event.
     *
     * @param  \App\Models\Review  $review
     * @return void
     */
    public function updated(Review $review)
    {
        Cache::forget('restaurant_' . $review->restaurant_id . '_average_rating');
    }

    /**
     * Handle the review "deleted" event.
     *
     * @param  \App\Models\Review  $review
     * @return void
     */
    public function deleted(Review $review)
    {
        Cache::forget('restaurant_' . $review->restaurant_id . '_average_rating');
    }
}
