@extends('layouts.app')

@section('content')
    <div class="container">

        <h2 class="card-title">Название альбома: {{ $album->title }}</h2>

        <div class="row mt-5">
чето в цикле
            <div class="row mt-5">
                @foreach($posts as $post)
                    <div class="col-lg-4">
                        <a data-fancybox="gallery" data-thumb="{{ env('APP_URL') }}/s3/{{ $user->id }}/{{ $post->id }}" href="{{ env('APP_URL') }}/s3full/{{ $user->id }}/{{ $post->id }}">
                            <div class="mb-4"
                                 style="height: 300px; background-image: url('{{ env('APP_URL') }}/s3/{{ $user->id }}/{{ $post->id }}');  background-size: cover;">
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
конец цикла
            {{ $posts->links() }}
еще цикл
           @foreach($posts as $post)
               <div class="col-sm-4">
                   <a href="/p/{{ $user->id }}/{{ $post->id }}">
                       <div class="mb-4"
                            style="height: 300px; background-image: url('/storage/{{ $post->image }}');  background-size: cover;">
                           style="height: 300px; background-image: url('{{ env('APP_URL') }}/s3/{{ $user->id }}/{{ $post->id }}');  background-size: cover;">
                       </div>
                   </a>
               </div>
           @endforeach
           конец
           $posts->links()
               {{ $posts->links() }}

        </div>

    </div>
@endsection
