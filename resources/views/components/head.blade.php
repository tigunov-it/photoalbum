<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Photoalbum, фотоальбом  - сервис для хранения фото ">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Что то сделать</title>
   {{-- <title>{{ config('app.name', 'Photoalbum') }}</title> --}}
	
       <!-- Font Awesome -->
    <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        rel="stylesheet"
    />
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap"
		rel="stylesheet">

	
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">	
	<link rel="stylesheet" href="{{ asset("css/style.css") }}">
	     <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
	<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	<script src="https://kit.fontawesome.com/ca29c702c8.js" crossorigin="anonymous"></script>


</head>

