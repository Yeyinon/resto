@extends('master')

@section('guest')
    <title>Search Results</title>
    <main>
        <div class="container">
            <h1>Search Results</h1>
            <div class="row">
                @foreach ($restaurants as $restaurant)
                    <div class="col-md-4">
                        <div class="strip">
                            <figure>
                                <img src="{{ asset('assets-home/img/detail_3.jpg') }}" class="img-fluid" alt="">
                                <a href="{{ route('book',$restaurant->id) }}" class="strip_info text-white">
                                    <h3>{{ $restaurant->name }}</h3>
                                    <small>{{ $restaurant->location }}</small>
                                </a>
                            </figure>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
