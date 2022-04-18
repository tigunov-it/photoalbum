<!DOCTYPE html>
<html lang="ru">
	{{-- @component('alert', ['foo' => 'bar']) --}}
	<x-head></x-head>
	<body>
		<x-header></x-header>
		<main>
			<!-- Слоган -->
			@section('starting')
				<div class="slider">
					<section class="slider-brend-1  wrap">
						<h2>
							Мгновения проходят,  
							<br>
							<mark><span>а фото остаются.</span></mark>
						</h2> 
					</section>
				</div>		
			@show
			{{-- Слайдер --}}
			<x-slaider></x-slaider>
		</main>
		<footer>
			@section('head-footer')
				<x-footer.head-footer></x-footer.head-footer>       
			@show
			<x-footer.footer-copyright></x-footer.footer-copyright>
		</footer>
	</body>
</html>
