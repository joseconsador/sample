<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\CreateReview;
use App\Http\Requests\UpdateReview;
use App\Http\Resources\Review\ReviewCollection;
use App\Http\Resources\Review\ReviewResource;
use App\Models\Restaurant;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @return ResourceCollection
     */
    public function index(Request $request, Restaurant $restaurant)
    {
        return new ReviewCollection($restaurant->reviews()
            ->paginate($request->query('per_page'))
            ->appends($request->query->all()));
    }

    /**
     * Display reviews with pending replies.
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @return ResourceCollection
     */
    public function pending(Request $request, Restaurant $restaurant)
    {
        return new ReviewCollection($restaurant->reviews()
            ->scopes(['withPendingReplies'])
            ->paginate($request->query('per_page'))
            ->appends($request->query->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateReview $request
     * @param Restaurant $restaurant
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateReview $request, Restaurant $restaurant)
    {
        /**
         * @var $user User
         */
        $user = Auth::user();
        if (!$user->hasRole('admin') || !$request->has('user_id')) {
            $userId = $user->getKey();
        } else {
            $userId = $request->get('user_id');
        }

        // Find an existing review from this user for this restaurant.
        $review = Review::firstOrNew(['restaurant_id' => $restaurant->getKey(), 'user_id' => $userId]);
        $review->fill($request->validated());
        $review->save();

        return (new ReviewResource($review))
            ->response()
            ->header('Location', route('api::restaurant::show::reviews::show', [
                'restaurant' => $restaurant->getKey(),
                'review' => $review->getKey()
            ]));
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param Restaurant $restaurant
     * @param Review $review
     * @return ReviewResource
     */
    public function show(Request $request, Restaurant $restaurant, Review $review)
    {
        if ($request->has('include')) {
            $relations = array_intersect(explode(',', $request->query('include')), $review->getExportableRelations());
            $review->load($relations);
        };

        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateReview $request
     * @param Restaurant $restaurant
     * @param Review $review
     * @return ReviewResource
     */
    public function update(UpdateReview $request, Restaurant $restaurant, Review $review)
    {
        $fields = $request->validated();

        /**
         * @var $user User
         */
        $user = Auth::user();
        if (!$user->hasRole('admin') || !$request->has('user_id')) {
            $userId = $user->getKey();
        } else {
            $userId = $request->get('user_id');
        }

        $review->fill($fields);
        $review->user_id = $userId;
        $review->save();

        return new ReviewResource($review);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
