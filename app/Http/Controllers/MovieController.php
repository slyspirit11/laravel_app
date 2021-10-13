<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /*Реализуйте контроллер с действиями index, create, store, edit, update, show,
destroy. Реализуйте соответствующие пути в routes/web.php. Правила
именования.*/
    public function index(){
        $movies = Movie::all();
        return view('index', compact('movies'));
    }
    public function create(){
        $movies = Movie::all();
        return view('create', compact('movies'));
    }
    public function store(){
        $movies = Movie::all();
        return view('store', compact('movies'));
    }
    public function edit(){
        $movies = Movie::all();
        return view('edit', compact('movies'));
    }
    public function update(){
        $movies = Movie::all();
        return view('update', compact('movies'));
    }
    public function show(Movie $movie){
        return view('modal_content', [
            'currentMovie' => $movie,
        ]);
    }
    public function destroy(){
        $movies = Movie::all();
        return view('destroy', compact('movies'));
    }
}
