@section('style')
    <link href="{{ asset('css/foto.css') }}" rel="stylesheet">
@endsection
@extends('layouts.app')

@section('content')
<div class="foto-albums">  
    <h2>Альбомы</h2>
    {{-- @can('update', $user->profile)
        <a href={{asset("/a/create")}}>
            <button class="btn" >Добавить альбом</button>
        </a>
    @endcan --}}
    <label class="btn" for="profile-form-hider" id="clickme"><b>Добавить альбом</b></label>

    {{-- форма редактирования --}}
    <div class="profile-form">
        <input type="checkbox" id="profile-form-hider">
        <div class="profile-form-edit">
            <form action={{asset("/a")}} enctype="multipart/form-data" method="post">
                @csrf
                <div class="row">
                    <div class="col-8 offset-2">
                        <div class="row">
                            <h1>Add new album</h1>
                        </div>

                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label">Title</label>

                            <input id="title"
                                type="text"
                                class="form-control @error('title') is-invalid @enderror"
                                name="title"
                                value="{{ old('title') }}"
                                autocomplete="title">

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror

                        </div>

                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label">Album Description</label>

                            <input id="description"
                                type="text"
                                class="form-control @error('description') is-invalid @enderror"
                                name="description"
                                value="{{ old('description') }}"
                                autocomplete="description">

                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                            @enderror

                        </div>
                        <div class="row">
                            <label for="image" class="col-md-4 col-form-label">Image</label>
                            <input type="file" class="form-control" id="image" name="image">
                            @error('image')

                                            <strong>{{ $message }}</strong>

                            @enderror
                        </div>

                        <div class="row mt-5">
                            <button class="btn btn-primary">Add new album</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>    
    <a href="#"><p title="Все фотографии">Все фотографии</p></a>
</div>
<div>  
    <h2>Фотографии</h2>
    @can('update', $user->profile)
        <a href={{asset("/p/create")}}>
            <button class="btn">Добавить фото</button>
        </a>
    @endcan
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
@endsection

@section('head-footer')
@endsection