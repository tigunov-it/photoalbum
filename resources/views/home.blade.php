<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="BRAND - торговая организация, продающая широкий спектр модной, люксовой одежды и аксесуаров для мужчин, женщин и детей. ">
	<title>Фотоальбом</title>
	<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,300;0,400;0,700;0,900;1,400&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="{{ asset("css/style.css") }}">
	<script src="https://kit.fontawesome.com/ca29c702c8.js" crossorigin="anonymous"></script>
</head>

<body>
	<header>
		<h1 class="hide">Фотоальбом</h1>
			<div class="wrap">
				<!-- логотип -->
				<div class="logotip">
					<a href="#" aria-label="Logotip"> 
						<img src="{{ asset("svg/IMG/ImgIndex/logo.png")}}" alt="Logotip"> 
						{{-- <p class="logo">Сделай мир ярче <span class="logo-D">D</span></p> --}}
					</a>
				</div>
				<!-- Поиск по сайту -->
				<!-- выбор из списка -->
				<section class="search">
					<!-- поиск в строке -->
					<form action="#" class="searsh-form">
						<input type="text" placeholder="Ищем...">
						<button type="submit" class="search-submit"> 
							<i class="fas fa-search"></i> 
						</button>
					</form>
				</section>
				<!-- корзина и аккаунт -->
				<section class="login">
					<a href="checkout.html" class="but-login but-account">
						Войти 
					</a>
					<br>
					<a href="checkout.html" class="but-registration but-account">
						Зарегистрироваться 
					</a>
				</section>
			</div>
	<hr>
		<!-- навигация -->
		<div class="wrap">
			<nav class="nav-header">
				<a href="#" aria-label="Пока не понятно" class="nav-header-a"><mark>Что то можно написать</mark></a>
				<!-- скрытое мега меню -->
				<div class="nav-hide-megamenu">
					<div class="nav-megamenu-col">
						<h3>фотографии</h3>
						<ul>
							<li><a  href="#">Люди </a></li>
							<li><a href="#">Природа</a></li>
						</ul>
					</div>
					<div class="nav-megamenu-col">
						<h3>Рисунки</h3>
						<ul>
							<li><a  href="#">Детские</a></li>
							<li><a href="#">Профи</a></li>
						</ul>
					</div>
				</div>
				<a href="#" aria-label="Пока не понятно"  class="nav-header-a"><mark>Контакты</mark></a>
				<!-- скрытое мега меню -->
				<div class="nav-hide-megamenu">
					<div class="nav-megamenu-col">
						<h3>Информация</h3>
						<ul>
							<li><a  href="#">О нас</a></li>
							<li><a href="#">Обратная связь</a></li>
						</ul>
					</div>
					<div class="nav-megamenu-col">
						<h3>Правила</h3>
						<ul>
							<li><a  href="#">Правила в чате</a></li>
							<li><a href="#">Правила опуьликования</a></li>
						</ul>
					</div>
				</div>
				<a href="#" aria-label="Пока не понятно"  class="nav-header-a"><mark>Оплата</mark></a>
				<!-- скрытое мега меню -->
				<div class="nav-hide-megamenu">
					<div class="nav-megamenu-col">
						<h3>Оплата</h3>
						<ul>
							<li><a  href="#">Карта</a></li>
							<li><a href="#">Крипта</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</header>

	<main>
	<!-- Первый слайдер -->
	<div class="slider">
		<section class="slider-brend-1  wrap">
			<h2>
				Мгновения проходят,  
				<br>
				<mark><span>а фото остаются.</span></mark>
			</h2> 
		</section>
	</div>
<!-- Категории -->
	<section class="category">
		<div class="categors-1">
			<a href="product.html" aria-label="FOR MEN">
				<article article class="categor-Men">
					<h3>
						<mark>Природа</mark> 
					</h3>
				</article>
			</a>
			<a href="#" aria-label="ACCESORIES">
				<article class="categor-Acctsories">
					<h3>
						<mark>Девчонки</mark> 
					</h3>
				</article>
			</a>
		</div>
		<div class="categors-2">
			<a href="singlePage.html" aria-label="offer women">
				<article class="categor-Women">
					<h3>
						<mark>Закат</mark>
					</h3> 
				</article>
			</a>
			<a href="#" aria-label="FOR kids">
				<article class="categor-Kids">
					<h3>
						<mark>Домашние</mark> 
						<br>
						<span>животные</span>
					</h3> 
				</article>
			</a>
		</div>
</section>
<!-- Продукт -->
<section class="product">
<h2 class="product-Header">Различные фото</h2>
<p>Здесь представлены лучшие фото</p>
<ul>
	<li>
		<article>
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_1.png")}}" alt="Product">
			<h3><mark>Человеки</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
	<li>
		<article>
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_2.png")}}" alt="Product">
			<h3><mark>Еще человеки</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
	<li>
		<article>
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_3.png")}}" alt="Product">
			<p></p>
			<h3><mark>Один человек</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
	<li>
		<article>
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_4.png")}}" alt="Product">
			<p></p>
			<h3><mark>Просто чел</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
	<li>
		<article> 
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_5.png")}}" alt="Product">
			<p></p>
			<h3><mark>Фото</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
	<li>
		<article> 
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_6.png")}}" alt="Product">
			<p></p>
			<h3><mark>кто то</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
	<li>
		<article> 
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_7.png")}}" alt="Product">
			<p></p>
			<h3><mark>Фотка</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
	<li>
		<article> 
			<img src="{{ asset("svg/IMG/ImgIndex/main/product/prod_8.png")}}" alt="Product">
			<p></p>
			<h3><mark>People</mark></h3>
			<div class="product-star">
			</div>
		</article>
	</li>
</ul>
</section>
</main>
<!-- Подвал -->
<footer>
	<div class="head-footer">
		<div class="business">
		<!-- логотип -->
			<div class="logotip">
				<a href="#"> 
					<img src="{{ asset("svg/IMG/ImgIndex/logo.png")}}" alt="Logotip"> 
				</a>
			</div> 
			<section class="business-text">
				<h3>О компании</h3>	
				<p> Наша компания лучшая и тд.</p> <br>
				<p>Мы стремимся и тд. </p>
			</section>
	</div>
		<article>
			<table>
				<tr>
					<th> О компании</th>
					<th>Контактная информация</th>
					<th>Отзывы</th>
				</tr>
				<tr>
					<td><a href="#">Цель</a></td>
					<td><a href="#">Адрес</a></td>
					<td><a href="#">Отзывы</a> </td>
				</tr>
				<tr>
					<td><a href="#">Автор</a></td>
					<td><a href="#">Телефон</a></td>
					<td><a href="#">Наши спонсоры</a></td>
				</tr>
				<tr>
					<td><a href="#">Лидер</a></td>
					<td><a href="#">Работа</a></td>
					<td><a href="#">Что то </a></td>
				</tr>
				<tr>
					<td><a href="#">Правила</a></td>
					<td><a href="#">Емайл</a></td>
					<td><a href="#">Наши компаньены</a></td>
				</tr>
			</table>
		</article>
	</div>
	<article class="copyright">
		<h2 class="hide">Соцсети</h2>
		<p>&copy;&nbsp;2017 Все Права Защищены.</p>
		<ul>
			<li> 
				<a href="#" aria-label="faisbuk"><i class="fab fa-facebook-f"></i></a>
				{{-- <img src="{{ asset("svg/IMG/ImgIndex/main/footer/faisbuk.png")}}" alt="faisbuk"> --}}
			</li>
			<li>
				<a href="#" aria-label="twitter"> <i class="fab fa-twitter"></i> </a>
				<!-- <img src="../IMG/ImgIndex/main/footer/twitter.png" alt="twitter"> -->
			</li>
			<li>
				<a href="#" aria-label="linkedin"><i class="fab fa-linkedin-in"></i></a>
				<!-- <img src="../IMG/ImgIndex/main/footer/linkedin.png" alt="linkedin"> -->
			</li>
			<li>
				<a href="#" aria-label="pinteres"><i class="fab fa-pinterest-p"></i> </a>
				<!-- <img src="../IMG/ImgIndex/main/footer/pinteres.png" alt="pinteres"> -->
			</li>
			<li>
				<a href="#" aria-label="gugl"><i class="fab fa-google-plus-g"></i></a>
				<!-- <img src="../IMG/ImgIndex/main/footer/gugl.png" alt="gugl"> -->
			</li>
		</ul>
	</article>
</footer>
</body>

</html>


{{-- @extends('layouts.app') --}}


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