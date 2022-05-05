<nav class="nav-header">
    {{-- {{var_dump(route("login"))}} --}}
    {{-- {{dd(url()->current())}} --}}
    {{-- @if ( url()->current()!=route("home") or url()->current()!=route("login") ) --}}
    @if ( stristr(url()->current(),'profile')==true)
        <a href="{{ asset("/index.php")}}" aria-label="Пока не понятно"  class="nav-header-a"><mark>Главная</mark></a>
    @endif 
    {{-- href="{{route ( 'profile.show', ['user'=>Auth::user()->id])}}" --}}
    @if ( stristr(url()->current(),'profile')==true)
        <a href="{{route('albums.index', ['user'=>Auth::user()->id])}}" aria-label="Пока не понятно"  class="nav-header-a"><mark>Мои фотоальбомы</mark></a>
        <!-- скрытое мега меню -->
    @endif 
    @if ( stristr(url()->current(),'profile')==true)
        <a href="{{route('albums.showFoto', ['user'=>Auth::user()->id])}}" aria-label="Пока не понятно"  class="nav-header-a"><mark>Мои фотографии!!!!</mark></a>
       {{-- <a href="/profile/{{ Auth::user()->id }}" aria-label="Пока не понятно"  class="nav-header-a"><mark>Мои фотографии</mark></a> --}}
        <!-- скрытое мега меню -->
    @endif     
    @if ( stristr(url()->current(), 'index')===false )
    <a href="#" aria-label="Пока не понятно" class="nav-header-a"><mark>Категории</mark></a>
    <!-- скрытое мега меню -->
    {{-- <div class="nav-hide-megamenu">
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
    </div> --}}
    @endif
    {{-- @if ( stristr(url()->current(),'login')==true) --}}
    <a href="#" aria-label="Пока не понятно"  class="nav-header-a"><mark>Категории</mark></a>
    <!-- скрытое мега меню -->
    <div class="nav-hide-megamenu">
        <div class="nav-megamenu-col">
            <h3>Природа</h3>
            <ul>
                <li><a  href="#">Рассвет</a></li>
                <li><a href="#">Дикие животные</a></li>
            </ul>
        </div>
    </div>
    {{-- @endif  --}}
    @if ( stristr(url()->current(),'login')==true)
    <a href="#" aria-label="Пока не понятно"  class="nav-header-a"><mark>Оплата</mark></a>
    <!-- скрытое мега меню -->
    @endif 





</nav>
