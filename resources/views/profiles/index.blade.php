@section('style')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
@endsection
@extends('layouts.app')
@section('content')
<div class="profile">
    {{-- фото --}}
    <div class="profile-foto" {{$url='https://mdbcdn.b-cdn.net/img/Photos/Slides/img%20(15).webp'}} style="background-image:url('{{$url}}')">
    </div>
    <div class="profile-info">
        <p><b>Имя:</b> {{ $user->username }}</p>
        <p><b>Логин:</b> {{ $user->profile->title }}</p>
        <p><b>О себе:</b> {{ $user->profile->description }}</p>
            @can('update', $user->profile)
                <a href="{{route('profile.edit', ['user'=>Auth::user()->id])}}">
                    <button class="btn">Редактировать</button>
                </a>
            @endcan            
    </div>
    <div class="profile-add-foto">
        @can('update', $user->profile)
            <a href={{asset("/p/create")}}>
                <button class="btn">Добавить фото</button>
            </a>
        @endcan
        <br>
        @can('update', $user->profile)
            <a href={{asset("/a/create")}}>
                <button class="btn">Добавить фотоальбом</button>
            </a>
        @endcan
    </div>
</div>
 



{{-- @section('content')
    <div class="profile">

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



        <div class="row mt-5">
            @foreach($user->posts as $post)
                <div class="col-sm-4">
                    <a href="/p/{{ $post->id }}">
                        <div class="mb-4"
                             style="height: 300px; background-image: url('/storage/{{ $post->image }}');  background-size: cover;">
                        </div>
                    </a>
                </div>
            @endforeach
        </div>


               {{-- <div class="row">
                   @foreach($user->posts as $post)
                       <div class="col-4">
                           <a href="/p/{{ $post->id }}">
                               <img
                                   src="/storage/{{ $post->image }}"
                                   class="w-100 shadow-1-strong rounded mb-4"
                                   alt="{{ $post->title }}"
                               />
                           </a>
                       </div>
                   @endforeach
               </div> --}}


    {{-- </div> --}} 
@endsection
@section('head-footer')
@endsection