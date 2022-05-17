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

        <div class="row mt-5">
            @foreach($user->album as $album)


                <div class="card-image col-md-3 mt-4">


                        <a href="/a/{{ $user->id }}/{{ $album->id }}">
                            <div class="d-flex justify-content-center align-items-end"
                                 style="height: 252px; background-image: url('{{ env('APP_URL') }}/s3album/{{ $user->id }}/{{ $album->id }}');  background-size: cover;">
                                <div class="mb-5">
                                    <span class="text-white fs-4">{{ $album->title }}</span>
                                </div>
                            </div>
                        </a>

                    <div class="card-image-icons d-flex w-100 justify-content-center">
                        <a href="" class="link-dark px-5">
                            <i class="fa-solid fa-info fs-2 text-white"></i>
                        </a>
                        <a href="" class="link-dark px-5">
                            <i class="fa-solid fa-file-arrow-down fs-2 text-white"></i>
                        </a>
                        <a href="" class="link-dark px-5">
                            <i class="fa-solid fa-trash-can fs-2 text-white"></i>
                        </a>
                    </div>

                </div>

            @endforeach
        </div>

    </div>
@endsection

