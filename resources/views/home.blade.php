{{-- @extends('layouts.app') --}}
СТАРТОВАЯ СТРАНИЦА

{{-- @section('content')
    <div class="container">

        <div class="row">
            <div class="col-8 p-5">
                <img src="/storage/{{$user->profile->image}}" alt="" class="rounded-circle">
                <div class="d-flex align-items-center justify-content-between">
                    <h1>{{ $user->username }}</h1>

                        <a href="/p/create">Add new post</a>

                </div>

                <a href="/profile/{{$user->id}}/edit">Edit profile</a>


                <h2>{{ $user->profile->title }}</h2>
                <h3>{{ $user->profile->description }}</h3>
                <div><a href="#">{{$user->profile->url }}</a></div>

            </div>
        </div>
        <div class="row">
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
        </div>
    </div>
@endsection --}}