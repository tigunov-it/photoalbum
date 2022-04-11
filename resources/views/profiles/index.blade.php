@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row border-bottom pb-3 d-flex align-items-center">
            <div class="col-2">
                <img src="{{ $user->profile->profileImage()}}" alt="" class="rounded-circle">
            </div>

            <div class="col-5">
                <h1>{{ $user->username }}</h1>
                <h2>{{ $user->profile->title }}</h2>
                <h3>{{ $user->profile->description }}</h3>
                <a href="#">{{$user->profile->url }}</a>
                <div class="pt-1">
                    @can('update', $user->profile)
                        <a href="/profile/{{$user->id}}/edit">
                            <button class="btn btn-warning btn-sm btn-block">Edit profile</button>
                        </a>
                    @endcan
                </div>

            </div>


            <div class="col-2 d-flex justify-content-center align-items-baseline">

                @can('update', $user->profile)
                    <a href="/p/create">
                        <button class="btn btn-success btn-lg btn-block">Add new photo</button>
                    </a>
                @endcan

            </div>

        </div>

        <div class="row mt-4">
            @foreach($user->posts as $post)
                <div class="col-4">
                    <a href="/p/{{ $post->id }}">
                        <div class="mb-4"
                             style="height: 300px; background-image: url('/storage/{{ $post->image }}');  background-size: cover;">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

    </div>
@endsection
