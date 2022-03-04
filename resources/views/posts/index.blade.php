@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">

                    <div class="card-header">
                        {{ __('Your posts') }}
                    </div>

                    <div class="card-body">
                        <a class="btn btn-info" href="{{ route('posts.create') }}">New Post</a>
                    </div>

                    <div class="card-body">
                        @foreach ($posts as $post)
                            @if (Auth::user()->id == $post->user_id)
                                <a href="{{ route('posts.show', $post->id) }}">
                                    <h3>{{ $post->title }}</h3>
                                </a>
                                <p>{{ $post->content }}</p>
                                <br>
                            @endif
                        @endforeach
                    </div>

                    <div class="card-header">
                        {{ __('Other posts') }}
                    </div>

                    <div class="card-body">
                        @foreach ($posts as $post)
                            @if (Auth::user()->id != $post->user_id)
                                <a href="{{ route('posts.show', $post->id) }}">
                                    <h3>{{ $post->title }}</h3>
                                </a>
                                <p>{{ $post->content }}</p>
                                <br>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
