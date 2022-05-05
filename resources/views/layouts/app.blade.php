<!DOCTYPE html>
{{-- <html lang="ru"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<x-head></x-head>
	<body>
        <header>
            <x-header.header></x-header.header>
        </header>
		<main>
			<!-- Слоган -->
			{{-- @section('starting')
				<div class="slider">
					<section class="slider-brend-1  wrap">
						<h2>
							Мгновения проходят,  
							<br>
							<mark><span>а фото остаются.</span></mark>
						</h2> 
					</section>
				</div>		
			@show --}}
            {{-- @yield('content') --}}
            <div  class="wrap">
                @section('content')
                    {{-- Слайдер --}}
                    {{-- <x-slaider></x-slaider> --}}
                    <x-slaider1></x-slaider1>            
                @show                
            </div>
		</main>
		<footer>
			@section('head-footer')
				<x-footer.head-footer></x-footer.head-footer>       
			@show
			<x-footer.footer-copyright></x-footer.footer-copyright>
		</footer>
	</body>