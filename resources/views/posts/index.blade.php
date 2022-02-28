@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <!--fem que la variable sigui opcional per a que no peti si no s'inicialitza (cas de quan nomes vol veure els seus posts)-->
                        @if ($seeAll ?? '')
                            {{ __('All posts') }}
                        @else
                            {{ __('Your posts') }}
                        @endif
                    </div>

                    <div class="card-body">
                        <a class="btn btn-info" href="{{ route('posts.create') }}">New Post</a>
                    </div>
                    <div class="card-body">
                        @foreach ($posts as $post)
                            <a href="{{ route('posts.show', $post->id) }}">
                                <h3>{{ $post->title }}</h3>
                            </a>
                            <p>{{ $post->content }}</p>
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
