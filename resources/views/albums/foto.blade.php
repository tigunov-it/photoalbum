@section('style')
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
@endsection
@extends('layouts.app')
@section('content')

            @foreach($user->posts as $post)
                <div class="col-sm-4">
                    <a href="/p/{{ $post->id }}">
                        <div class="mb-4"
                             style="height: 300px; background-image: url('/storage/{{ $post->image }}');  background-size: cover;">
                        </div>
                    </a>
                </div>
            @endforeach
@endsection
@section('head-footer')
@endsection