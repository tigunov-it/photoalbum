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
    </div>
</div>
@endsection
@section('head-footer')
@endsection