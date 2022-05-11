@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row border-bottom pb-3 d-flex align-items-center">

            <div class="col-lg-2">
                <img src="{{ $user->profile->profileImage()}}" alt="" class="rounded-circle">
            </div>

            <div class="col-lg-5">
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

            <div class="col-lg-2 d-flex justify-content-center align-items-baseline">

                @can('update', $user->profile)
                    <a href="/p/create">
                        <button class="btn btn-success btn-lg btn-block">Add new photo</button>
                    </a>
                @endcan

            </div>

            <div class="col-lg-2 d-flex justify-content-center align-items-baseline">

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

        <div class="row mt-5">

            <div class="row mt-5">
                @foreach($posts as $post)
                    <div class="col-lg-4">
                        <a data-fancybox="gallery" href="{{ env('APP_URL') }}/s3full/{{ $user->id }}/{{ $post->id }}">
                            <div class="mb-4"
                                 style="height: 300px; background-image: url('{{ env('APP_URL') }}/s3/{{ $user->id }}/{{ $post->id }}');  background-size: cover;">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            {{ $posts->links() }}

{{--            @foreach($posts as $post)--}}
{{--                <div class="col-sm-4">--}}
{{--                    <a href="/p/{{ $user->id }}/{{ $post->id }}">--}}
{{--                        <div class="mb-4"--}}
{{--                             style="height: 300px; background-image: url('/storage/{{ $post->image }}');  background-size: cover;">--}}
{{--                            style="height: 300px; background-image: url('{{ env('APP_URL') }}/s3/{{ $user->id }}/{{ $post->id }}');  background-size: cover;">--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--                {{ $posts->links() }}--}}

        </div>

    </div>
@endsection
