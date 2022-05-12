<!DOCTYPE html>
{{-- <html lang="ru"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<x-head></x-head>
	<body>
        <header>
            <x-header.header></x-header.header>
        </header>
		<main>
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
</html>