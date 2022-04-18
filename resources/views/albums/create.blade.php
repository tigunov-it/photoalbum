@extends('layouts.app')

@section('content')

    <div class="container">
        <form action="/a" enctype="multipart/form-data" method="post">
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
@endsection
