@extends('layouts.app')

@section('content')

    <div class="container vh-100">
        <div class="row mt-4">
            <div class="col-8">
                {{--                <img src="/storage/{{$post->image}}" alt="{{ $post->title }}" class="w-100">--}}
                <img src="{{ env('APP_URL') }}/s3medium/{{ $post->user->id }}/{{ $post->id }}" alt="{{ $post->title }}"
                     class="w-100">
            </div>
            <div class="col-4">
                <div>
                    <a href="/profile/{{$post->user->id}}"><img src="{{ $post->user->profile->profileImage() }}"
                                                                alt="User image" class="rounded-circle"
                                                                style="max-width: 60px"></a>

                </div>
                <div>
                    <div>
                        <a href="/profile/{{$post->user->id}}"><h3>{{$post->user->username}}</h3></a>
                    </div>
                    <h3>Title:</h3>
                    <p>{{$post->title}}</p>

                    <h3>Description:</h3>
                    <p>{{$post->description}}</p>

                    <div>
                        <h3>Album</h3>
                        <p>{{$post->album->title}}</p>
                    </div>

                    <form action="{{ route('post.rotate', ['post' => $post->id]) }}" method="GET">
                        @csrf

                        @method('GET')

                        <button type="submit" class="m-sm-2 btn btn-primary btn-block"><i
                                class="fa-solid fa-rotate-left"></i> Rotate
                        </button>
                    </form>


                    <form action="{{ route('post.destroy', ['post' => $post->id]) }}" method="POST">
                        @csrf

                        @method('DELETE')

                        <button type="submit" class="m-sm-2 btn btn-danger btn-block"><i class="fa-solid fa-trash"></i>
                            Delete
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

