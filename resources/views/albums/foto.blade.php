@section('style')
    <link href="{{ asset('css/foto.css') }}" rel="stylesheet">
    
@endsection
@extends('layouts.app')

@section('content')
<div class="foto-albums" > 
    <div class="managment">
        <div>
            <div class="profile-foto" {{$url='https://mdbcdn.b-cdn.net/img/Photos/Slides/img%20(15).webp'}} style="background-image:url('{{$url}}')">
            </div>   
            <a class="nav-header-a btn"  href="{{route ( 'profile.show', ['user'=>Auth::user()->id])}}">Страница профиля</a>        
        </div>

        <div class="profile-info" >
            <p><b>Имя:</b> {{ $user->username }}</p>
            {{-- <p><b>Логин:</b> {{ $user->profile->title }}</p> --}}
            <p><b>О себе:</b> {{ $user->profile->description }}</p>
        </div>
        <div class="foto-form-add-albums">  
            <label class="btn btn2" for="profile-form-hider" id="clickme"><b>Добавить альбом</b></label>
            {{-- форма добавить албом --}}
            <div class="profile-form">
                <input type="checkbox" id="profile-form-hider">
                <div class="profile-form-edit">
                    <form action={{asset("/a")}} enctype="multipart/form-data" method="post">  
                        @csrf
                        <div class="profile-form-div">
                            <label for="title" class="col-md-4 col-form-label">Название альбома:</label>
                            <input id="title"
                                type="text"
                                class="input @error('title') is-invalid @enderror"
                                name="title"
                                value="{{ old('title') }}"
                                autocomplete="title">
                        </div>
                        @error('title')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror
                        <div class="profile-form-div">
                            <label for="description" class="col-md-4 col-form-label">Описание альбома:</label>
                            <input id="description"
                                type="text"
                                class="input @error('description') is-invalid @enderror"
                                name="description"
                                value="{{ old('description') }}"
                                autocomplete="description">
                        </div>
                        @error('description')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                        @enderror                                
                        <div class="profile-form-div">
                            <label for="image" class="btn label">Выбрать фото на заставку</label>
                            <input type="file" id="image" style="display:none;" name="image" accept="image/*,image/jpeg">
                        </div>
                        @error('image')
                            <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror                                
                        <div class="profile-form-div-btn">
                            <button class="btn btn-primary">Создать альбом</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="foto-form-add-foto">
            <label class="btn btn2" for="profile-form-foto-hider" id="clickme"><b>Добавить фото</b></label>
                {{-- формадобавить фото --}}
                {{--  НЕ РАБОТАЕТ --}}
                <div class="profile-form">
                    <input type="checkbox" id="profile-form-foto-hider">
                    <div class="profile-form-edit">
                        <form action={{asset("/a")}} enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="profile-form-div">
                                <label for="title">Название:</label>
                                <input id="title"
                                    type="text"
                                    class="input @error('title') is-invalid @enderror"
                                    name="title"
                                    value="{{ old('title') }}"
                                    autocomplete="title">
                            </div>
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="profile-form-div">
                                <label for="description">Описание:</label>
                                <input id="description"
                                    type="text"
                                    class="input @error('description') is-invalid @enderror"
                                    name="description"
                                    value="{{ old('description') }}"
                                    autocomplete="description">
                            </div>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                                    
                            <div class="profile-form-div">
                                <label for="album" >Выбор альбома:</label>
                                <select class="select" aria-label="Default select example" name="album">
                                    @foreach($user->album as $album)
                                        <option value="{{ $album->id }}"> {{ $album->title }} </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('album')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror 
                            <div class="profile-form-div foto-add">
                                <label for="image" class="btn label">Выбрать фото на заставку</label>
                                <input type="file" id="image" multiple style="display:none;" name="image[]" accept="image/*,image/jpeg">
                            </div>                                   
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>    
                            @enderror                                    
                            <div class="profile-form-div-btn">
                                <button class="btn">Загрузить</button>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div> 

    <hr>
    <div class="foto-view">
        <a class="nav-link" href="{{route('albums.showFoto', ['user'=>Auth::user()->id])}}">Все фото</a>
        <a class="nav-link" href="{{route('albums.showFoto', ['user'=>Auth::user()->id])}}">Фотоальбом</a>
    </div>
    <hr class="foto-albums-hr">
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

    {{-- тоже ничего --}}
    {{-- <div class="col-lg-2" style="width: 200px">
        <img src="{{ $user->profile->profileImage()}}" alt="" class="rounded-circle" style="height: 200px">
    </div> --}}
</div>
@endsection

@section('head-footer')
@endsection