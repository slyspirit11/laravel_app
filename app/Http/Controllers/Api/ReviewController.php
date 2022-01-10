<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Movie;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::all()->where('user_id', '===', Auth::id());
        return response(['user reviews' => $reviews]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Movie $movie)
    {
        $validated = $this->getValidatedData();
        $validated['user_id'] = Auth::id();
        $validated['movie_id'] = $movie->id;
        $validated['published_at'] = date('Y-m-d H:i:s');
        $created_review = Review::create($validated);
        return response(['review was created' => $created_review]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Review $review
     * @return ReviewResource
     */
    public function show(Review $review)
    {
        return new ReviewResource($review);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function update(Review $review)
    {
        if(Auth::user()->is_admin || Auth::id() === $review->user_id){
            $validated = $this->getValidatedData();
            $review->update($validated);
            $review->refresh();
            return response(['review was updated' => $review]);
        }
        return response('Authenticated user cannot update this movie');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Review $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if(Auth::user()->is_admin || Auth::id() === $review->user_id) {
            $review->delete();
            return response('review was deleted.');
        }
        return response('Authenticated user cannot delete this movie');
    }

    protected function getValidatedData()
    {
        return request()->validate([
            'content' => ['required'],
            'rating' => ['required', 'min:1', 'max:10'],
        ]);
    }
}
