<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function showFeed(){
        $friends = Auth::user()->getFriends();
        $friend_ids = $friends->pluck('id');
        $movies = Movie::whereIn('user_id', $friend_ids)->get();
        $reviews = Review::whereIn('user_id', $friend_ids)->get();
        foreach($reviews as $review){
            $review->created_at = $review->published_at;
        }
        $movies_and_reviews = $movies->concat($reviews)->sortByDesc('created_at');
        return view('feed', compact(['movies_and_reviews']));
    }

    public function befriendUser(User $user){
        Auth::user()->befriend($user);
        $user->acceptFriendRequest(Auth::user());
        return redirect(RouteServiceProvider::HOME);
    }

    public function unfriendUser(User $user){
        Auth::user()->unfriend($user);
        return redirect(RouteServiceProvider::HOME);
    }
}
