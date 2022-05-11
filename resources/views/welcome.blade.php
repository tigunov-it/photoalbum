@extends('layouts.app')

@section('content')

    <div id="carouselExampleCaptions" class="carousel slide" data-mdb-ride="carousel">
        <div class="carousel-indicators">
            <button
                type="button"
                data-mdb-target="#carouselExampleCaptions"
                data-mdb-slide-to="0"
                class="active"
                aria-current="true"
                aria-label="Slide 1"
            ></button>
            <button
                type="button"
                data-mdb-target="#carouselExampleCaptions"
                data-mdb-slide-to="1"
                aria-label="Slide 2"
            ></button>
            <button
                type="button"
                data-mdb-target="#carouselExampleCaptions"
                data-mdb-slide-to="2"
                aria-label="Slide 3"
            ></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://mdbcdn.b-cdn.net/img/new/slides/041.webp" class="d-block w-100" alt="Wild Landscape"/>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Keep your memories</h5>
                    <p>Jog someone's memory.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://mdbcdn.b-cdn.net/img/new/slides/042.webp" class="d-block w-100" alt="Camera"/>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Share your creativity</h5>
                    <p>Get the creative juices flowing.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="https://mdbcdn.b-cdn.net/img/new/slides/043.webp" class="d-block w-100" alt="Exotic Fruits"/>
                <div class="carousel-caption d-none d-md-block">
                    <h5>Let your imagination run riot</h5>
                    <p>Magic touch.</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-mdb-target="#carouselExampleCaptions" data-mdb-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-mdb-target="#carouselExampleCaptions" data-mdb-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

@endsection
