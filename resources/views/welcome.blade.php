@extends('layouts.app')

@section('content')

    <!-- Carousel wrapper -->
    <div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">

        <!-- Inner -->
        <div class="carousel-inner">

            <!-- Single item -->
            <div style="background-image: url('{{ env('APP_URL') . '/images/slides/sakura.jpg' }}');
            background-repeat: no-repeat;
            background-size: cover"
                 class="carousel-item active">

                <div class="carousel-caption">

                    <div class="text-white mb-12">
                        <h1 class="mb-3">Keep your memories</h1>
                        <h4 class="mb-3">Jog someone's memory</h4>
                        @if(Auth::user())
                            <a class="btn btn-outline-light btn-lg" href="/profile/{{ Auth::user()->id }}"
                               role="button"
                            >Go to My Profile</a
                            >
                        @else
                            <a class="btn m-1 btn-outline-light btn-lg" href="{{ env('APP_URL') . '/register' }}"
                               role="button"
                            >Start for free</a
                            >
                            <a class="btn m-1 btn-outline-light btn-lg" href="{{ env('APP_URL') . '/login' }}"
                               role="button"
                            >Log in</a
                            >
                        @endif
                    </div>

                </div>
            </div>

            <!-- Single item -->
            <div style="background-image: url('{{ env('APP_URL') . '/images/slides/nepal.jpg' }}');
            background-repeat: no-repeat;
            background-size: cover"
                 class="carousel-item">

                <div class="carousel-caption">

                    <div class="text-white mb-12">
                        <h1 class="mb-3">Share your creativity</h1>
                        <h4 class="mb-3">Get the creative juices flowing</h4>
                        @if(Auth::user())
                            <a class="btn btn-outline-light btn-lg" href="/profile/{{ Auth::user()->id }}"
                               role="button"
                            >Go to My Profile</a
                            >
                        @else
                            <a class="btn m-1 btn-outline-light btn-lg" href="{{ env('APP_URL') . '/register' }}"
                               role="button"
                            >Start for free</a
                            >
                            <a class="btn m-1 btn-outline-light btn-lg" href="{{ env('APP_URL') . '/login' }}"
                               role="button"
                            >Log in</a
                            >
                        @endif
                    </div>

                </div>
            </div>

            <!-- Single item -->
            <div style="background-image: url('{{ env('APP_URL') . '/images/slides/slide3.webp' }}');
            background-repeat: no-repeat;
            background-size: cover"
                 class="carousel-item">

                <div class="carousel-caption">

                    <div class="text-white mb-12">
                        <h1 class="mb-3">Let your imagination run riot</h1>
                        <h4 class="mb-3">Magic touch beta</h4>
                        @if(Auth::user())
                            <a class="btn btn-outline-light btn-lg" href="/profile/{{ Auth::user()->id }}"
                               role="button"
                            >Go to My Profile</a
                            >
                        @else
                            <a class="btn m-1 btn-outline-light btn-lg" href="{{ env('APP_URL') . '/register' }}"
                               role="button"
                            >Start for free</a
                            >
                            <a class="btn m-1 btn-outline-light btn-lg" href="{{ env('APP_URL') . '/login' }}"
                               role="button"
                            >Log in</a
                            >
                        @endif
                    </div>

                </div>
            </div>

            <!-- Inner -->

            <!-- Carousel wrapper -->

@endsection
