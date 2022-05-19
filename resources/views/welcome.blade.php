@extends('layouts.app')

@section('content')

    <!-- Carousel wrapper -->
    <div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">

        <!-- Indicators -->
{{--        <div class="carousel-indicators">--}}
{{--            <button--}}
{{--                type="button"--}}
{{--                data-mdb-target="#carouselBasicExample"--}}
{{--                data-mdb-slide-to="0"--}}
{{--                class="active"--}}
{{--                aria-current="true"--}}
{{--                aria-label="Slide 1"--}}
{{--            ></button>--}}
{{--            <button--}}
{{--                type="button"--}}
{{--                data-mdb-target="#carouselBasicExample"--}}
{{--                data-mdb-slide-to="1"--}}
{{--                aria-label="Slide 2"--}}
{{--            ></button>--}}
{{--            <button--}}
{{--                type="button"--}}
{{--                data-mdb-target="#carouselBasicExample"--}}
{{--                data-mdb-slide-to="2"--}}
{{--                aria-label="Slide 3"--}}
{{--            ></button>--}}
{{--        </div>--}}

        <!-- Inner -->
        <div class="carousel-inner">
            <!-- Single item -->
            <div class="carousel-item active">
                <img src="{{ env('APP_URL') . '/images/slides/slide1.webp' }}" class="d-block w-100" alt="Sunset Over the City"/>
                <div class="carousel-caption d-none d-md-block">

                    <div class="text-white mb-8">
                        <h1 class="mb-3">Keep your memories</h1>
                        <h4 class="mb-3">Jog someone's memory</h4>
                        <a class="btn btn-outline-light btn-lg" href="http://photoalbum.test/login" role="button"
                        >Start for free</a
                        >
                    </div>

                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <img src="{{ env('APP_URL') . '/images/slides/slide2.webp' }}" class="d-block w-100" alt="Canyon at Nigh"/>
                <div class="carousel-caption d-none d-md-block">

                    <div class="text-white mb-8">
                        <h1 class="mb-3">Share your creativity</h1>
                        <h4 class="mb-3">Get the creative juices flowing</h4>
                        <a class="btn btn-outline-light btn-lg" href="http://photoalbum.test/login" role="button"
                        >Start for free</a
                        >
                    </div>

                </div>
            </div>

            <!-- Single item -->
            <div class="carousel-item">
                <img src="{{ env('APP_URL') . '/images/slides/slide3.webp' }}" class="d-block w-100" alt="Cliff Above a Stormy Sea"/>
                <div class="carousel-caption d-none d-md-block">

                    <div class="text-white mb-8">
                        <h1 class="mb-3">Let your imagination run riot</h1>
                        <h4 class="mb-3">Magic touch</h4>
                        <a class="btn btn-outline-light btn-lg" href="http://photoalbum.test/login" role="button"
                        >Start for free</a
                        >
                    </div>

                </div>
            </div>
        </div>
        <!-- Inner -->

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Carousel wrapper -->

@endsection
