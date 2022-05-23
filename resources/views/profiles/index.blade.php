@section('style')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet">
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

        <label class="btn" for="profile-form-hider" id="clickme"><b>Редактировать</b></label>
    </div>
    {{-- форма редактирования --}}
    <div class="profile-form">
        <input type="checkbox" id="profile-form-hider">
        <div class="profile-form-edit">
            <form action="{{route ( 'profile.show', ['user'=>Auth::user()->id])}}" enctype="multipart/form-data" method="post">
                @csrf
                @method('PATCH')
                <h3 class="h3">Редактирование профиля</h3>
                <div class="profile-form-div">
                    <label for="title"><b>Логин:</b></label>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror                    
                    <input id="title" 
                            placeholder="Логин?"
                            type="text"
                            class="input  @error('title') is-invalid @enderror"
                            name="title"
                            value="{{ old('title') ?? $user->profile->title }}"
                            autocomplete="title">
                </div>
                <div class="profile-form-div">
                    <label for="description"><b>О себе:</b></label>
                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input id="description" 
                            placeholder="О себе"
                            type="text"
                            class="input @error('description') is-invalid @enderror"
                            name="description"
                            value="{{ old('description') ?? $user->profile->description }}"
                            autocomplete="description">
                </div>
                {{-- <div class="profile-form-div">
                    <label for="url"><b>URL:</b></label>
                    @error('url')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <input id="url" 
                            placeholder="Что?"
                            type="text"
                            class="input @error('url') is-invalid @enderror"
                            name="url"
                            value="{{ old('url') ?? $user->profile->url }}"
                            autocomplete="url">
                </div> --}}
                <div class="profile-form-div">
                    <label for="image" class="btn">Загрузить фото для профиля</label>
                    @error('image')
                        <strong>{{ $message }}</strong>
                    @enderror                    
                    <input type="file" id="image" style="display:none;" name="image" accept="image/*,image/jpeg">
                </div>
                <div class="profile-form-save">
                    <button class="btn"><b>Сохранить изменения</b></button>
                </div>
            </form>
        </div>

    <div class="container-fluid">

        <div class="row border-bottom pb-3 d-flex align-items-center justify-content-md-center"
             style="background-image: url('{{ env('APP_URL') . '/images/slides/slide3.webp' }}'); background-size: cover;"
        >

            <div class="container col-sm-2 d-flex flex-column align-items-center justify-content-end">

                <img src="{{ $user->profile->profileImage()}}" alt="" class="w-25 rounded-circle">

                <div class="pt-1">
                    @can('update', $user->profile)
                        <a href="/profile/{{$user->id}}/edit">
                            <button class="btn btn-sm btn-outline-light"><i class="fa-solid fa-ellipsis text-white"></i></button>
                        </a>
                    @endcan
                </div>

            </div>

            <div class="container col-sm-4">
                <h2 class="text-white">{{ $user->username }}</h2>
                <h3 class="text-white">{{ $user->profile->title }}</h3>
                <h4 class="text-white">{{ $user->profile->description }}</h4>
                <a class="text-white" href="#">{{$user->profile->url }}</a>
            </div>

            <div class="col-lg-2 pt-2 d-flex justify-content-center align-items-baseline">

                @can('update', $user->profile)
                    <a href="/p/create">
                        <button class="btn btn-outline-light">Add new photo</button>
                    </a>
                @endcan

            </div>

            <div class="container col-lg-2 pt-2 d-flex justify-content-center align-items-baseline">

                @can('update', $user->profile)
                    <a href="/a/create">
                        <button class="btn btn-outline-light">Add new album</button>
                    </a>
                @endcan

            </div>

        </div>




                <div class="container grid mt-5">

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

{{--                <div class="row mt-5">--}}

{{--                    @foreach($posts as $post)--}}
{{--                    <div class="col card-image mb-4">--}}

{{--                        <a data-fancybox="gallery"--}}
{{--                           data-thumb="{{ env('APP_URL') }}/s3small/{{ $user->id }}/{{ $post->id }}"--}}
{{--                           data-download-src="{{ env('APP_URL') }}/s3large/{{ $user->id }}/{{ $post->id }}"--}}
{{--                           href="{{ env('APP_URL') }}/s3large/{{ $user->id }}/{{ $post->id }}">--}}

{{--                            <div class="flex-column"--}}
{{--                                 style="height: 300px; background-image: url('{{ env('APP_URL') }}/s3medium/{{ $user->id }}/{{ $post->id }}');  background-size: cover;">--}}
{{--                            </div>--}}

{{--                        </a>--}}

{{--                        <div class="card-image-icons d-flex w-100 justify-content-center">--}}
{{--                            <a href="/p/{{ $user->id }}/{{ $post->id }}" class="link-dark px-5">--}}
{{--                                <i class="fa-solid fa-info fs-2 text-white"></i>--}}
{{--                            </a>--}}
{{--                            <a href="/download/{{ $user->id }}/{{ $post->id }}" class="link-dark px-5">--}}
{{--                                <i class="fa-solid fa-file-arrow-down fs-2 text-white"></i>--}}
{{--                            </a>--}}
{{--                            <a href="{{ route('post.destroy', ['post' => $post->id]) }}" class="link-dark px-5">--}}
{{--                                <i class="fa-solid fa-trash-can fs-2 text-white"></i>--}}
{{--                            </a>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    @endforeach--}}
{{--                </div>--}}

    </div>
</div>
@endsection
@section('head-footer')
@endsection