@extends('heartman')
@section('title', 'What rain has to offer')

@section('content')
    <div>
        <h1>{{$wow}}</h1>
        <p>It's really hard to concentrate. Not to fall into the world of blurry naive opinions</p>
        <ul>
            @forelse($words as $word)
                <li>{{$word}}</li>
            @empty
                <li>There is no word</li>
            @endforelse
        </ul>
    </div>
@endsection
