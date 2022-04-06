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
				<!--аккаунт и регистрация -->
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
				<a href="#" aria-label="Пока не понятно" class="nav-header-a"><mark>Категории</mark></a>
				<!-- скрытое мега меню -->
				<div class="nav-hide-megamenu">
					<div class="nav-megamenu-col">
						<h3>Категории</h3>
						<ul>
							<li><a  href="#">Портрет</a></li>
							<li><a href="#">Пейзаж</a></li>
							<li><a  href="#">Предметная фотография</a></li>
							<li><a  href="#">Архитектурная фотография</a></li>
						</ul>
					</div>
					<div class="nav-megamenu-col">
						<h3>Категории</h3>
						<ul>
							<li><a  href="#">Дикие животные</a></li>
							<li><a href="#">Подводная фотосъемка</a></li>
						</ul>
					</div>
				</div>
				<a href="#" aria-label="Пока не понятно"  class="nav-header-a"><mark>Правила</mark></a>
				<!-- скрытое мега меню -->
				<div class="nav-hide-megamenu">
					<div class="nav-megamenu-col">
						<h3>Информация</h3>
						<ul>
							<li><a  href="#">Правила опубликования</a></li>
							<li><a href="#">Обратная связь</a></li>
						</ul>
					</div>
				</div>
				<a href="#" aria-label="Пока не понятно"  class="nav-header-a"><mark>Оплата</mark></a>
				<!-- скрытое мега меню -->
				<div class="nav-hide-megamenu">
					<div class="nav-megamenu-col">
						<h3>Оплата за дополнительную память</h3>
						<ul>
							<li><a  href="#">Правила оплаты</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
	</header>

	<main>
	<!-- Слоган -->
	<div class="slider">
		<section class="slider-brend-1  wrap">
			<h2>
				Мгновения проходят,  
				<br>
				<mark><span>а фото остаются.</span></mark>
			</h2> 
		</section>
	</div>
	{{-- Слайдер --}}
<section id="slider_bl" class="wrap">
	<div class="wrapper">
	  <input checked type=radio name="slider" id="slide1" />
	  <input type=radio name="slider" id="slide2" />
	  <input type=radio name="slider" id="slide3" />
	  <input type=radio name="slider" id="slide4" />
	  <div class="slider-wrapper">
	    <div class=inner>
	      <article>
			<section class="categori">
				<div class="categori-1">
					<article article class="categori-Men">
						<a href="product.html" aria-label="FOR MEN">
							<h3>
								<mark>Природа</mark> 
							</h3>
						</a>
					</article>
					<article class="categori-Acctsories">
						<a href="#" aria-label="ACCESORIES">
							<h3>
								<mark>Девчонки</mark> 
							</h3>
						</a>
					</article>
				</div>
				<div class="categori-2">
					<article class="categori-Women">
						<a href="singlePage.html" aria-label="offer women">
							<h3>
								<mark>Закат</mark>
							</h3>
						</a> 
					</article>
					<article class="categori-Kids">
						<a href="#" aria-label="FOR kids">
							<h3>
								<mark>Домашние</mark> 
								<br>
								<span>животные</span>
							</h3> 
						</a>						
					</article>
				</div>
			</section>
	      </article>
	      <article>
			<section class="categori">
				<div class="categori-1">
					<article article class="categori-Men">
						<a href="product.html" aria-label="FOR MEN">
							<h3>
								<mark>Природа</mark> 
							</h3>
						</a>
					</article>
					<article class="categori-Acctsories">
						<a href="#" aria-label="ACCESORIES">
							<h3>
								<mark>Девчонки</mark> 
							</h3>
						</a>
					</article>
				</div>
				<div class="categori-2">
					<article class="categori-Women">
						<a href="singlePage.html" aria-label="offer women">
							<h3>
								<mark>Закат</mark>
							</h3>
						</a> 
					</article>
					<article class="categori-Kids">
						<a href="#" aria-label="FOR kids">
							<h3>
								<mark>Домашние</mark> 
								<br>
								<span>животные</span>
							</h3> 
						</a>						
					</article>
				</div>
			</section>
	      </article>
	      <article>
			<section class="categori">
				<div class="categori-1">
					<article article class="categori-Men">
						<a href="product.html" aria-label="FOR MEN">
							<h3>
								<mark>Природа</mark> 
							</h3>
						</a>
					</article>
					<article class="categori-Acctsories">
						<a href="#" aria-label="ACCESORIES">
							<h3>
								<mark>Девчонки</mark> 
							</h3>
						</a>
					</article>
				</div>
				<div class="categori-2">
					<article class="categori-Women">
						<a href="singlePage.html" aria-label="offer women">
							<h3>
								<mark>Закат</mark>
							</h3>
						</a> 
					</article>
					<article class="categori-Kids">
						<a href="#" aria-label="FOR kids">
							<h3>
								<mark>Домашние</mark> 
								<br>
								<span>животные</span>
							</h3> 
						</a>						
					</article>
				</div>
			</section>
	      </article>
	      <article>
			<section class="categori">
				<div class="categori-1">
					<article article class="categori-Men">
						<a href="product.html" aria-label="FOR MEN">
							<h3>
								<mark>Природа</mark> 
							</h3>
						</a>
					</article>
					<article class="categori-Acctsories">
						<a href="#" aria-label="ACCESORIES">
							<h3>
								<mark>Девчонки</mark> 
							</h3>
						</a>
					</article>
				</div>
				<div class="categori-2">
					<article class="categori-Women">
						<a href="singlePage.html" aria-label="offer women">
							<h3>
								<mark>Закат</mark>
							</h3>
						</a> 
					</article>
					<article class="categori-Kids">
						<a href="#" aria-label="FOR kids">
							<h3>
								<mark>Домашние</mark> 
								<br>
								<span>животные</span>
							</h3> 
						</a>						
					</article>
				</div>
			</section>
	      </article>
	    </div>
	  </div>
	  <div class="slider-prev-next-control">
	    <label for=slide1></label>
	    <label for=slide2></label>
	    <label for=slide3></label>
	    <label for=slide4></label>
	  </div>
	  <div class="slider-dot-control">
	    <label for=slide1></label>
	    <label for=slide2></label>
	    <label for=slide3></label>
	    <label for=slide4></label>
	  </div>
	</div>
</section>
</main>
<!-- Подвал -->

<footer>
	<hr>
	<div class ="wrap">
		<div class="head-footer">
			<div class="footer-bisness">
				<!-- логотип -->
				<div class="logotip">
					<a href="#"> 
						<img src="{{ asset("svg/IMG/ImgIndex/logo.png")}}" alt="Logotip"> 
					</a>
				</div> 
				<section class="business-text">
					<h3>О компании</h3>	
					<p> Наша компания лучшая и тд. !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!</p> <br>
					<p>Мы стремимся и тд. </p>
				</section>
			</div>
			<div class ="footer-inform">
				<section>
					<h3>О компании</h3>
					<a href=""><p>Правила</p></a>
					<a href=""><p>Цель</p></a>
				</section>
				<section>
					<h3>Контактная информация</h3>
					<a href=""><p>Телефон</p></a>
					<a href=""><p>Емайл</p></a>
					<a href=""><p>Адрес</p></a>
				</section>
				<section>
					<h3>Отзывы</h3>
					<a href=""><p>Отзывы</p></a>
					<a href=""><p>Спонсоры</p></a>
				</section>
			</div>
		</div>
	</div>
	<div  class ="wrap">
		<div class="footer-copyright">
			<h2 class="hide">Соцсети</h2>
			<p>&copy;&nbsp;2017 Все Права Защищены.</p>
			<div class="footer-label">
					<a href="#" aria-label="faisbuk"><i class="fab fa-facebook-f"></i></a>
					<a href="#" aria-label="twitter"> <i class="fab fa-twitter"></i> </a>
					<a href="#" aria-label="linkedin"><i class="fab fa-linkedin-in"></i></a>
					<a href="#" aria-label="pinteres"><i class="fab fa-pinterest-p"></i> </a>
					<a href="#" aria-label="gugl"><i class="fab fa-google-plus-g"></i></a>
			</div>
		</div>				
	</div>
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