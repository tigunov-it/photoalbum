<!DOCTYPE html>
{{-- <html lang="ru"> --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
			{{-- <x-slaider></x-slaider> --}}
		</main>
		<footer>
			@section('head-footer')
				<x-footer.head-footer></x-footer.head-footer>       
			@show
			<x-footer.footer-copyright></x-footer.footer-copyright>
		</footer>
	</body>
{{-- =======
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<body>
<div id="app">
 

    <main class="py-4">
        @yield('content')
    </main>
</div>
<div class="container">


    <!-- Footer -->
    <footer class="text-center text-lg-start bg-light text-muted">
        <!-- Section: Social media -->
        <section
            class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"
        >
            <!-- Left -->
            <div class="me-5 d-none d-lg-block">
                <span>Get connected with us on social networks:</span>
            </div>
            <!-- Left -->

            <!-- Right -->
            <div>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-google"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-linkedin"></i>
                </a>
                <a href="" class="me-4 text-reset">
                    <i class="fab fa-github"></i>
                </a>
            </div>
            <!-- Right -->
        </section>
        <!-- Section: Social media -->

        <!-- Section: Links  -->
        <section class="">
            <div class="container text-center text-md-start mt-5">
                <!-- Grid row -->
                <div class="row mt-3">
                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                        <!-- Content -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            <i class="fas fa-gem me-3"></i>Photo Albmum
                        </h6>
                        <p>
                            Keep your memories. Share your creativity.
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Apps
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">iOS</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Android</a>
                        </p>

                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Community
                        </h6>
                        <p>
                            <a href="#!" class="text-reset">Blog</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Forum</a>
                        </p>
                        <p>
                            <a href="#!" class="text-reset">Help</a>
                        </p>
                    </div>
                    <!-- Grid column -->

                    <!-- Grid column -->
                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                        <!-- Links -->
                        <h6 class="text-uppercase fw-bold mb-4">
                            Contact
                        </h6>
                        <p><i class="fas fa-home me-3"></i> Russia, Irkutsk, Baikal lake</p>
                        <p>
                            <i class="fas fa-envelope me-3"></i>
                            info@example.com
                        </p>
                        <p><i class="fas fa-phone me-3"></i> + 71 234 567 88</p>
                    </div>
                    <!-- Grid column -->
                </div>
                <!-- Grid row -->
            </div>
        </section>
        <!-- Section: Links  -->

        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
            <script>
                document.write("Copyright &copy; " + new Date().getFullYear() + " PhotoAlbum. All rights reserved.");
            </script>
        </div>
        <!-- Copyright -->
    </footer>
    <!-- Footer -->
</div>
</body>
>>>>>>> Start page. Add menu 'My profile', route
</html> --}}
