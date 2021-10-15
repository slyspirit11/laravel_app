<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class MovieController extends Controller
{
    /*Реализуйте контроллер с действиями index, create, store, edit, update, show,
destroy. Реализуйте соответствующие пути в routes/web.php. Правила
именования.*/
    public function index()
    {
        $movies = Movie::all();
        return view('movie.index', compact('movies'));
    }

    public function create()
    {
        return view('movie.create');
    }

    public function store(Request $request)
    {
        $validated = $this->getValidatedData();
        $poster = $validated['poster'];
        if (isset($poster)) {
            $extension = $poster->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $poster->move('images/movies/', $filename);
            Image::make(public_path('images/movies/' . $filename))->fit(500, 800)->save();
            $validated['poster_path'] = $filename;
        }
        unset($validated['poster']);
        Movie::create($validated);
        return redirect('/');
    }

    public function edit(Movie $movie)
    {
        return view('movie.edit', compact('movie'));
    }

    public function update(Movie $movie)
    {
        $validated = $this->getValidatedData();
        $poster = $validated['poster'];
        if (isset($poster)) {
            $extension = $poster->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $poster->move('images/movies/', $filename);
            Image::make(public_path('images/movies/' . $filename))->fit(500, 800)->save();
            $validated['poster_path'] = $filename;
        }
        unset($validated['poster']);
        $movie->update($validated);
        return redirect('/movies/'.$movie->id);
    }

    public function show(Movie $movie)
    {
        return view('movie.modal_content', compact('movie'));
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect('/');
    }

    protected function getValidatedData(){
        return request()->validate([
            'title' => ['required'],
            'director' => ['required'],
            'year' => ['required', 'gte:1878'],
            'synopsys' => ['nullable'],
            'poster' => ['nullable', 'max:64', 'mimes:jpg,jpeg,png'],
        ]);

    }
}
