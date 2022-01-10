<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Gate::allows('show-trashed')) {
            $movies = Movie::withTrashed()->where('user_id', Auth::id())->get();
        } else {
            $movies = Movie::all()->where('user_id', '===', Auth::id());
        }
        return response($movies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::authorize('create', Movie::class)) {

            $validated = $this->getValidatedData();
            $default_image_name = '1638265565.jpg';
            $validated['poster_path'] = $default_image_name;
            $validated['user_id'] = Auth::id();
            $is_movie_created = Movie::create($validated);
            return response(['movie was created' => $is_movie_created]);
        }
        return response('Authenticated user cannot create movies.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Movie $movie
     * @return MovieResource
     */
    public function show(Movie $movie)
    {
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Movie $movie)
    {
        if (Gate::authorize('update', $movie)) {
            $validated = $this->getValidatedData();
            $default_image_name = '1638265565.jpg';
            $validated['poster_path'] = $default_image_name;
            $movie->update($validated);
            $movie->refresh();
            return response(['movie was updated' => $movie]);
        }
        return response('Authenticated user cannot update this movie');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Movie $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        if (Gate::authorize('delete', $movie)) {
            $reviews = $movie->reviews;
            foreach ($reviews as $review) {
                $review->delete();
            }
            $movie->delete();
            return response('Movie deleted.');
        }
        return response('Authenticated user cannot delete this movie.');
    }

    protected function getValidatedData()
    {
        return request()->validate([
            'title' => ['required'],
            'director' => ['required'],
            'year' => ['required', 'gte:1878'],
            'synopsys' => ['nullable'],
            'poster' => ['nullable', 'max:64', 'mimes:jpg,jpeg,png'],
        ]);

    }
}
