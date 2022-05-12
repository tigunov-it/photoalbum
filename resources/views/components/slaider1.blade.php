@section('content')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // инициализация слайдера
        new ItcSimpleSlider('.itcss', {
            loop: true,//зациклиность
            autoplay: false,//автопрокрутка
            interval: 1800,//время прокрутки
            swipe: true, //менять свайпом
        });
    });
</script>
<section id="slider_bl">
<!-- Разметка слайдера (html код) -->
    <div class="itcss">
        <div class="itcss__wrapper">
            <div class="itcss__items">
                <div class="itcss__item">
                    {{-- тут фон --}}
                    <section class="slider-brend-1  wrap">
                        <h2>
                            Мгновения проходят,  
                            <br>
                            <mark><span>а фото остаются.</span></mark>
                        </h2> 
                    </section>
                </div>
                <div class="itcss__item">
                    {{-- тут фотка  --}}
                    <img src="https://mdbcdn.b-cdn.net/img/Photos/Slides/img%20(15).webp" class="slaider1-slaid2" alt="Sunset Over the City"/>
                </div>
                <div class="itcss__item">
                    <!-- Контент 3 слайда -->				
	                <article  class="slaider1-slaid1">Тут че нить написать можно</article>
                </div>
                <div class="itcss__item">
                    <!-- Контент 4 слайда --><article  class="slaider1-slaid4"></article>
                </div>
            </div>
        </div>
    <!-- Стрелки для перехода к предыдущему и следующему слайду -->
    <a class="itcss__control itcss__control_prev" href="#" role="button" data-slide="prev"></a>
    <a class="itcss__control itcss__control_next" href="#" role="button" data-slide="next"></a>
    </div>
</section>
@endsection