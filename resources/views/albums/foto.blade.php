@section('style')
    <link href="{{ asset('css/foto.css') }}" rel="stylesheet">
    
@endsection
@extends('layouts.app')

@section('content')
<div class="foto-albums">  
    <div class="profile-foto" {{$url='https://mdbcdn.b-cdn.net/img/Photos/Slides/img%20(15).webp'}} style="background-image:url('{{$url}}')">
    </div>
    <div class="profile-info">
        <p><b>Имя:</b> {{ $user->username }}</p>
        <p><b>Логин:</b> {{ $user->profile->title }}</p>
        <p><b>О себе:</b> {{ $user->profile->description }}</p>

        <label class="btn" for="profile-form-hider" id="clickme"><b>Редактировать</b></label>
    </div>


    <h2>Альбомы</h2>
    <label class="btn" for="profile-form-hider" id="clickme"><b>Добавить альбом</b></label>
    {{-- форма редактирования --}}
    {{-- НЕ РАБОТАЕТ?? --}}
    <div class="profile-form">
        <input type="checkbox" id="profile-form-hider">
        <div class="profile-form-edit">
            {{-- action={{asset("/a")}} может тут ч ет не то? --}}
            <form action={{asset("/a")}} enctype="multipart/form-data" method="post">  
                @csrf
                <div class="row">
                    <div class="col-8 offset-2">
                        <div class="row">
                            <h3>Создать альбом</h3>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label">Название альбома</label>
                            <input id="title"
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                name="title"
                                value="{{ old('title') }}"
                                autocomplete="title">
                            @error('title')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label">Описание альбома</label>
                            <input id="description"
                                type="text"
                                class="form-control @error('description') is-invalid @enderror"
                                name="description"
                                value="{{ old('description') }}"
                                autocomplete="description">
                            @error('description')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="row">
                            <label for="image" class="col-md-4 col-form-label">Фото на заставку</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')
                                <strong>{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="row mt-5">
                            <button class="btn btn-primary">Создать альбом</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
<div>  
    <h2>Фотографии</h2>
    <label class="btn" for="profile-form-foto-hider" id="clickme"><b>Добавить фото</b></label>
        {{-- форма редактиррования --}}
        {{-- ТОЖЕ НЕ РАБОТАЕТ --}}
        <div class="profile-form">
            <input type="checkbox" id="profile-form-foto-hider">
            <div class="profile-form-edit">
                <form action={{asset("/a")}} enctype="multipart/form-data" method="post">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @csrf
                    <div class="row">
                        <div class="col-8 offset-2">
                            <div class="row">
                                <h3>Добавить новую фотку</h3>
                            </div>
                            <div class="row mb-3">
                                <label for="title" class="col-md-4 col-form-label">Название</label>
                                <input id="title"
                                    type="text"
                                    class="form-control @error('title') is-invalid @enderror"
                                    name="title"
                                    value="{{ old('title') }}"
                                    autocomplete="title">
                                            {{--                        @error('title')--}}
                                            {{--                        <span class="invalid-feedback" role="alert">--}}
                                            {{--                                        <strong>{{ $message }}</strong>--}}
                                            {{--                                    </span>--}}
                                            {{--                        @enderror--}}
                            </div>
                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label">Описание</label>
                                <input id="description"
                                    type="text"
                                    class="form-control @error('description') is-invalid @enderror"
                                    name="description"
                                    value="{{ old('description') }}"
                                    autocomplete="description">
                                                {{--                        @error('description')--}}
                                                {{--                        <span class="invalid-feedback" role="alert">--}}
                                                {{--                                        <strong>{{ $message }}</strong>--}}
                                                {{--                                    </span>--}}
                                                {{--                        @enderror--}}
                            </div>
                            <div class="row mb-3">
                                <label for="album" class="col-md-4 col-form-label">Выбор альбома</label>
                                <select class="form-select" aria-label="Default select example" name="album">
                                    @foreach($user->album as $album)
                                        <option value="{{ $album->id }}"> {{ $album->title }} </option>
                                    @endforeach
                                </select>
                                        {{--                        @error('album')--}}
                                        {{--                        <span class="invalid-feedback" role="alert">--}}
                                        {{--                                        <strong>{{ $message }}</strong>--}}
                                        {{--                                    </span>--}}
                                        {{--                        @enderror--}}
                            </div>
                            <div class="row">
                                <label for="image" class="col-md-4 col-form-label">Выбрать фотку</label>
                                <input type="file" multiple class="form-control" id="image" name="image[]">
                                    {{--                        @error('image')--}}
                                    {{--                                        <strong>{{ $message }}</strong>--}}
                                    {{--                        @enderror--}}
                            </div>
                            <div class="row mt-5">
                                <button class="btn btn-primary">Загрузить</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
</div>
<div>
        {{-- НИЧЕГО НЕ ВЫВОДИТ? --}}
    @foreach($user->posts as $post)
        <div class="col-sm-4">
            <a href="/p/{{ $post->id }}">
                <div class="mb-4"
                        style="height: 300px; background-image: url('/storage/{{ $post->image }}');  background-size: cover;">
                </div>
                чет длжно быть
            </a>
        </div>
    @endforeach 
</div>
<div class="container">
    <div class=" border-bottom">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="{{route('albums.showFoto', ['user'=>Auth::user()->id])}}">PhotoStream</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('albums.showFoto', ['user'=>Auth::user()->id])}}">PhotoAlbums</a>
            </li>
        </ul>
    </div>
{{-- Тоже ничего не выводит --}}
    <div class="row mt-5">
        @foreach($user->album as $album)
            <div class="col-sm-4">
                <a href="/a/{{ $user->id }}/{{ $album->id }}">
                    <div class="mb-4 d-flex justify-content-center align-items-center"
                         style="height: 300px; background-image: url('/storage/{{ $album->image }}');  background-size: cover;">
                        <div>
                            <h3 class="text-white fs-1">{{ $album->title }}</h3>

                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
    {{-- тоже ничего --}}
    <div class="col-lg-2" style="width: 200px">
        <img src="{{ $user->profile->profileImage()}}" alt="" class="rounded-circle" style="height: 200px">
    </div>
@endsection

@section('head-footer')
@endsection