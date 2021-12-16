<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class MovieController extends Controller
{

    public function index(User $user)
    {
        if (Gate::allows('show-trashed')) {
            $movies = Movie::withTrashed()->where('user_id', $user->id)->get();
        } else {
            $movies = Movie::all()->where('user_id', '===', $user->id);
        }
        return view('movie.index', compact('movies', 'user'));
    }

    public function create(User $user)
    {
        if (Gate::authorize('create', Movie::class)) {
            return view('movie.create', compact('user'));
        }
    }

    public function store()
    {
        if (Gate::authorize('create', Movie::class)) {

            $validated = $this->getValidatedData();
            $validated = $this->addPosterPathAttribute($validated);
            $validated['user_id'] = Auth::id();
            Movie::create($validated);
            return redirect(route('movies', ['user' => Auth::user()->name]));
        }
    }

    public function edit(User $user, Movie $movie)
    {
        if (Gate::authorize('update', $movie)) {
            return view('movie.edit', compact('user', 'movie'));
        }
    }

    public function update(User $user, Movie $movie)
    {
        if (Gate::authorize('update', $movie)) {
            $validated = $this->getValidatedData();
            $validated = $this->addPosterPathAttribute($validated);
            $movie->update($validated);
            return redirect(route('movies.show', ['user' => $user->name, 'movie' => $movie->id]));
        }
    }

    public function show(User $user, Movie $movie)
    {
        return view('movie.modal_content', compact('user', 'movie'));
    }

    public function destroy(User $user, Movie $movie)
    {
        if (Gate::authorize('delete', $movie)) {
            $reviews = $movie->reviews;
            foreach ($reviews as $review) {
                $review->delete();
            }
            $movie->delete();
            return redirect(route('movies', ['user' => $user->name, 'movie' => $movie->id]));
        }
    }

    public function forceDelete(User $user, Movie $movie)
    {
        if (Gate::authorize('forceDelete', $movie)) {
            $reviews = Review::withTrashed()->where('movie_id', $movie->id)->get();
            foreach ($reviews as $review) {
                $review->forceDelete();
            }
            $movie->forceDelete();
            return redirect(route('movies', ['user' => $user->name, 'movie' => $movie->id]));
        }
    }

    public function restore(User $user, Movie $movie)
    {
        if (Gate::authorize('restore', $movie)) {
            $reviews = Review::withTrashed()->where('movie_id', $movie->id)->get();
            foreach ($reviews as $review) {
                $review->restore();
            }
            $movie->restore();
            return redirect(route('movies', ['user' => $user->name]));
        }
    }

    protected function addPosterPathAttribute(array $validated)
    {
        $poster = null;
        if (array_key_exists('poster', $validated)) {
            $poster = $validated['poster'];
        }
        if (isset($poster)) {
            $extension = $poster->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $poster->move('images/movies/', $filename);
            Image::make(public_path('images/movies/' . $filename))->fit(500, 800)->save();
            $validated['poster_path'] = $filename;
        }
        unset($validated['poster']);
        return $validated;
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
