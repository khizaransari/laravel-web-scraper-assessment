@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Top Rated Movies</h1>
        <ul class="list-group">
            @foreach ($movies as $movie)
                <li class="list-group-item">
                    <div>
                        <h4><a href="{{ $movie->url }}">{{ $movie->title }}</a></h4>
                    </div>
                    <div>Year: {{ $movie->year }}</div>
                    <div>Rating: {{ $movie->rating }}</div>
                </li>
            @endforeach
        </ul>
        <div class="mt-3">
            {{ $movies->links() }}
        </div>
    </div>
@endsection
