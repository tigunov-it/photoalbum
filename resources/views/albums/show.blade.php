@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row border-bottom pb-3 d-flex align-items-center">

            <div class="col-sm-2 d-flex flex-column align-items-center">
                <img src="{{ $user->profile->profileImage()}}" alt="" class="w-75 rounded-circle">

                <div class="pt-1">
                    @can('update', $user->profile)
                        <a href="/profile/{{$user->id}}/edit">
                            <button class="btn btn-warning btn-sm btn-block">Edit profile</button>
                        </a>
                    @endcan
                </div>

            </div>

            <div class="col-md-4">
                <h1>{{ $user->username }}</h1>
                <h2>{{ $user->profile->title }}</h2>
                <h3>{{ $user->profile->description }}</h3>
                <a href="#">{{$user->profile->url }}</a>

            </div>

            <div class="col-lg-2 pt-2 d-flex justify-content-center align-items-baseline">

                @can('update', $user->profile)
                    <a href="/p/create">
                        <button class="btn btn-success btn-lg btn-block">Add new photo</button>
                    </a>
                @endcan

            </div>

            <div class="col-lg-2 pt-2 d-flex justify-content-center align-items-baseline">

                @can('update', $user->profile)
                    <a href="/a/create">
                        <button class="btn btn-success btn-lg btn-block">Add new album</button>
                    </a>
                @endcan

            </div>

        </div>

        <div class=" border-bottom">

            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link" href="/profile/{{ Auth::user()->id }}">PhotoStream</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/a/{{ Auth::user()->id }}">PhotoAlbums</a>
                </li>

            </ul>

        </div>

        <h1 class="card-title">Album: {{ $album->title }}</h1>

        <div class="grid mt-5">

            @foreach($posts as $post)
                <div class="card-image mb-3">

                    <a data-fancybox="gallery"
                       data-thumb="{{ env('APP_URL') }}/s3small/{{ $user->id }}/{{ $post->id }}"
                       data-download-src="{{ env('APP_URL') }}/s3large/{{ $user->id }}/{{ $post->id }}"
                       href="{{ env('APP_URL') }}/s3large/{{ $user->id }}/{{ $post->id }}">

                        <img src="{{ env('APP_URL') }}/s3medium/{{ $user->id }}/{{ $post->id }}" alt="">

                    </a>

                    <div class="card-image-icons d-flex w-100 justify-content-center">
                        <a href="/p/{{ $user->id }}/{{ $post->id }}" class="link-dark px-5">
                            <i class="fa-solid fa-info fs-2 text-white"></i>
                        </a>
                        <a href="/download/{{ $user->id }}/{{ $post->id }}" class="link-dark px-5">
                            <i class="fa-solid fa-file-arrow-down fs-2 text-white"></i>
                        </a>
                        <a href="{{ route('post.destroy', ['post' => $post->id]) }}" class="link-dark px-5">
                            <i class="fa-solid fa-trash-can fs-2 text-white"></i>
                        </a>
                    </div>

                </div>

            @endforeach
        </div>

    </div>
@endsection
