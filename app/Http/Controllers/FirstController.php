<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FirstController extends Controller
{
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
