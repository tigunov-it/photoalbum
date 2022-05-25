<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Photoalbum') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>

<div id="app">
    {{--    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
    <nav class="navbar navbar-expand-md bg-opacity-75 bg-dark navbar-light">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">

                {{--                    {{ config('app.name', 'Laravel') }}--}}
                {{--                <div><img src="/svg/camera2.svg" alt="logo" style="height: 50px; border-right: 1px solid black"--}}
                {{--                          class="px-3"></div>--}}

                <svg style="fill: red;" xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                     class="bi bi-camera2" viewBox="0 0 16 16">
                    <path d="M5 8c0-1.657 2.343-3 4-3V4a4 4 0 0 0-4 4z"/>
                    <path
                        d="M12.318 3h2.015C15.253 3 16 3.746 16 4.667v6.666c0 .92-.746 1.667-1.667 1.667h-2.015A5.97 5.97 0 0 1 9 14a5.972 5.972 0 0 1-3.318-1H1.667C.747 13 0 12.254 0 11.333V4.667C0 3.747.746 3 1.667 3H2a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1h.682A5.97 5.97 0 0 1 9 2c1.227 0 2.367.368 3.318 1zM2 4.5a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0zM14 8A5 5 0 1 0 4 8a5 5 0 0 0 10 0z"/>
                </svg>

                <div class="ms-3 px-3 text-white" style="border-left: 1px solid white">PhotoAlbum</div>
            </a>

            <button class="bg-light navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="text-white nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="text-white nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else

                        <li class="nav-item">
                            <a class="text-white nav-link" href="/profile/{{ Auth::user()->id }}">My proffile</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="text-white nav-link dropdown-toggle" href="#" role="button"
                               data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->username }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{--    <main class="py-4">--}}

    <main class="">
        @yield('content')
    </main>
</div>


<!-- Footer -->
{{--    <footer class="text-center text-lg-start bg-light text-muted">--}}
{{--        <!-- Section: Social media -->--}}
{{--        <section--}}
{{--            class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"--}}
{{--        >--}}
{{--            <!-- Left -->--}}
{{--            <div class="me-5 d-none d-lg-block">--}}
{{--                <span>Get connected with us on social networks:</span>--}}
{{--            </div>--}}
{{--            <!-- Left -->--}}

{{--            <!-- Right -->--}}
{{--            <div>--}}
{{--                <a href="" class="me-4 text-reset">--}}
{{--                    <i class="fab fa-facebook-f"></i>--}}
{{--                </a>--}}
{{--                <a href="" class="me-4 text-reset">--}}
{{--                    <i class="fab fa-twitter"></i>--}}
{{--                </a>--}}
{{--                <a href="" class="me-4 text-reset">--}}
{{--                    <i class="fab fa-google"></i>--}}
{{--                </a>--}}
{{--                <a href="" class="me-4 text-reset">--}}
{{--                    <i class="fab fa-instagram"></i>--}}
{{--                </a>--}}
{{--                <a href="" class="me-4 text-reset">--}}
{{--                    <i class="fab fa-linkedin"></i>--}}
{{--                </a>--}}
{{--                <a href="" class="me-4 text-reset">--}}
{{--                    <i class="fab fa-github"></i>--}}
{{--                </a>--}}
{{--            </div>--}}
{{--            <!-- Right -->--}}
{{--        </section>--}}
{{--        <!-- Section: Social media -->--}}

{{--        <!-- Section: Links  -->--}}
{{--        <section class="">--}}
{{--            <div class="container text-center text-md-start mt-5">--}}
{{--                <!-- Grid row -->--}}
{{--                <div class="row mt-3">--}}
{{--                    <!-- Grid column -->--}}
{{--                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">--}}
{{--                        <!-- Content -->--}}
{{--                        <h6 class="text-uppercase fw-bold mb-4">--}}
{{--                            <i class="fas fa-gem me-3"></i>Photo Albmum--}}
{{--                        </h6>--}}
{{--                        <p>--}}
{{--                            Keep your memories. Share your creativity.--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                    <!-- Grid column -->--}}

{{--                    <!-- Grid column -->--}}
{{--                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">--}}
{{--                        <!-- Links -->--}}
{{--                        <h6 class="text-uppercase fw-bold mb-4">--}}
{{--                            Apps--}}
{{--                        </h6>--}}
{{--                        <p>--}}
{{--                            <a href="#!" class="text-reset">iOS</a>--}}
{{--                        </p>--}}
{{--                        <p>--}}
{{--                            <a href="#!" class="text-reset">Android</a>--}}
{{--                        </p>--}}

{{--                    </div>--}}
{{--                    <!-- Grid column -->--}}

{{--                    <!-- Grid column -->--}}
{{--                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">--}}
{{--                        <!-- Links -->--}}
{{--                        <h6 class="text-uppercase fw-bold mb-4">--}}
{{--                            Community--}}
{{--                        </h6>--}}
{{--                        <p>--}}
{{--                            <a href="#!" class="text-reset">Blog</a>--}}
{{--                        </p>--}}
{{--                        <p>--}}
{{--                            <a href="#!" class="text-reset">Forum</a>--}}
{{--                        </p>--}}
{{--                        <p>--}}
{{--                            <a href="#!" class="text-reset">Help</a>--}}
{{--                        </p>--}}
{{--                    </div>--}}
{{--                    <!-- Grid column -->--}}

{{--                    <!-- Grid column -->--}}
{{--                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">--}}
{{--                        <!-- Links -->--}}
{{--                        <h6 class="text-uppercase fw-bold mb-4">--}}
{{--                            Contact--}}
{{--                        </h6>--}}
{{--                        <p><i class="fas fa-home me-3"></i> Russia, Irkutsk, Baikal lake</p>--}}
{{--                        <p>--}}
{{--                            <i class="fas fa-envelope me-3"></i>--}}
{{--                            info@example.com--}}
{{--                        </p>--}}
{{--                        <p><i class="fas fa-phone me-3"></i> + 71 234 567 88</p>--}}
{{--                    </div>--}}
{{--                    <!-- Grid column -->--}}
{{--                </div>--}}
{{--                <!-- Grid row -->--}}
{{--            </div>--}}
{{--        </section>--}}
{{--        <!-- Section: Links  -->--}}

<footer class="footer">
    <!-- Copyright -->
    <div class="bg-dark text-white text-center bg-opacity-75 p-4">
        <script>
            document.write("Copyright &copy; " + new Date().getFullYear() + " PhotoAlbum. All rights reserved.");
        </script>
    </div>
    <!-- Copyright -->
</footer>
<!-- Footer -->


</body>
</html>
