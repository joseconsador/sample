<?php

namespace App\Http\Controllers\API;

use App\Models\Restaurant;
use App\Http\Resources\Review as ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ReviewsController extends BaseAPIController
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index(Request $request, Restaurant $restaurant)
    {
        return new ResourceCollection($restaurant->reviews()
            ->paginate($request->query('per_page'))
            ->appends($request->query->all()));
    }

    /**
     * Display reviews with pending replies.
     *
     * @return ResourceCollection
     */
    public function pending(Request $request, Restaurant $restaurant)
    {
        return new ResourceCollection($restaurant->reviews()
            ->scopes(['withPendingReplies'])
            ->paginate($request->query('per_page'))
            ->appends($request->query->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Restaurant $restaurant)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param Review $review
     * @return ReviewResource
     */
    public function show(Restaurant $restaurant, Review $review)
    {
        return new ReviewResource($review);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
