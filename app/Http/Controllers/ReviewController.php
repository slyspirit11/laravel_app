<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(User $user, Movie $movie)
    {
        $validated = $this->getValidatedData();
        $validated['user_id'] = Auth::id();
        $validated['movie_id'] = $movie->id;
        $validated['published_at'] = date('Y-m-d H:i:s');
        Review::create($validated);
        return redirect(route('movies.show', ['user' => $user->name, 'movie' => $movie->id]));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }

    protected function getValidatedData()
    {
        return request()->validate([
            'content' => ['required'],
            'rating' => ['required', 'min:1', 'max:10'],
        ]);
    }
}
