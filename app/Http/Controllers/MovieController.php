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
    public function show(){
        $movies = Movie::all();
        return view('show', compact('movies'));
    }
    public function destroy(){
        $movies = Movie::all();
        return view('destroy', compact('movies'));
    }
    //------------------------------------------------------------
    public function rain()
    {
        $tears = 'Go to hell from Islandalia';
        return view('rainman', data:[
            'hey' => $tears,
        ]);
    }
    public function heart()
    {
        $drips = 'Make a pie, please, please, please';
        $words = [
            'Word1',
            'Word2',
            'Word3',
            'Word919'
        ];
        return view('hearts', data:[
            'wow' => $drips,
            'words' => $words,
        ]);
    }
}
