@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-8">
                <img src="/storage/{{$post->image}}" alt="{{ $post->title }}" class="w-100">
            </div>
            <div class="col-4">
                <div>
                    <a href="/profile/{{$post->user->id}}"><img src="{{ $post->user->profile->profileImage() }}" alt="User image" class="rounded-circle" style="max-width: 60px"></a>

                </div>
                <div>
                    <div>
                        <a href="/profile/{{$post->user->id}}"><h3>{{$post->user->username}}</h3></a>
                    </div>

                    <p>{{$post->title}}</p>
                    <p>{{$post->description}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

