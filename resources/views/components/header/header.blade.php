    
<h1 class="hide">Фотоальбом</h1>
    <div class="wrap">
        <!-- логотип -->
        <div class="logotip">
            <a href="{{ asset("/index.php")}}" aria-label="Logotip"> 
                <img src="{{ asset("svg/IMG/ImgIndex/logo.png")}}" alt="Logotip"> 
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
    @guest
        <section class="login">
                <input type="radio" name="authorization" id="authorization-on" >
                <label for="authorization-on" class="btn" title="Вход"><b>Войти</b></label>

                <label for="authorization-off" class="but-login-off" title="Выход" ></label>
                <input type="radio" name="authorization" id="authorization-off" checked >
            <div class="authorization-fon" >

                <div class="authorization" >
                    <input type="radio" name="tabs" id="tab-1" checked style="display: none">
                    <input type="radio" name="tabs" id="tab-2" style="display: none">

                    <label for="tab-1" class="but-authorization" title="Авторизация"><b>Авторизация</b></label>
                    <label for="tab-2" class="but-registration" title="Регистрация"><b>Регистрация</b></label>	

                        <div  class="forma1">
                            <form  method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="registr-name">
                                    <img src="{{ asset("svg/IMG/smail.svg")}}" alt="smail" class="registr-icon-smail">
                                    <input id="email" type="text" class="registr-user-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Логин" >

                                    {{-- <input class="registr-user-input" type="text" name="name" id="email" placeholder="Логин" > --}}
                                    {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus> --}}
                                    {{-- type email? --}}
                                </div>
                                <span class="invalid-feedback" role="alert">
                                    @error('email')
                                        <strong>{{ $message }}</strong>
                                    @enderror
                                </span>
                                <div class="registr-zamok">
                                    <img src="{{ asset("svg/IMG/zamok.svg")}}" alt="zamok" class="registr-icon-zamok">
                                    <input id="password" type="password" class="registr-zamok-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Пароль">
                                    
                                    {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                    <input class="registr-zamok-input" type="password" name="name" id="name" placeholder="Пароль"> --}}
                                </div>
                                <span class="invalid-feedback" role="alert" style="color: red">    
                                    @error('password')
                                        <strong>{{ $message }}</strong>
                                    @enderror    
                                </span>
                                <div class="regstr-entrance">
                                    <input class="registr-entrance-input" type="submit" value="Войти" />
                                </div>
                                <div class="registr-remember">
                                    <div class="regstr-radio-check">   
                                        <input type="radio" class="radio-no" id="no" name="remember" value="no" checked>
                                        <label for="no"><i class="fa fa-times"></i></label> 
                                        <input class="radio-yes" type="radio" name="remember" id="remember" value="yes" >

                                        {{-- <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <input type="radio" class="radio-yes" id="yes" name="remember" value="yes"> --}}
                                        <label  for="remember"><i class="fa fa-check"></i></label>
                                        
                                        {{-- <label class="form-check-label" for="remember">
                                        <label for="yes"><i class="fa fa-check"></i></label> --}}
                                        <span class="switch-selection"></span>
                                    </div>
                                        <span class="check-label">Запомнить меня</span>
                                        <span class="forgot-label">Забыли свой пароль?</span>	
                                </div>
                            </form>
                        </div>
                    <div class="forma2" >
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                {{-- <div class="registr-gender">
                                    <p class="registr-gender-p">Обращение</p>
                                    <label>
                                        <input type="radio" name="title" value="men" checked>
                                        Г-н
                                    </label>
                                    <label>
                                        <input type="radio" name="title" value="woman">
                                        Г-жа
                                    </label>
                                </div> --}}
                                <div class="registr-name">
                                    <img src="{{ asset("svg/IMG/id.svg")}}" alt="smail" class="registr-icon-identificati-name">



                                    <input id="name" type="text" placeholder="Имя" class="registr-user-input-name @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
            

                                    {{-- <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                    <input class="registr-user-input-name" type="text" name="name" id="name" placeholder="Имя" > --}}
                                </div>
                                    <span class="invalid-feedback" role="alert">
                                        @error('name')
                                            <strong>{{ $message }}</strong>
                                        @enderror
                                    </span>                                    	
                                <div class="registr-surname">
                                    <img src="{{ asset("svg/IMG/id.svg")}}" alt="smail" class="registr-icon-surname">
                                    <input id="username" type="username" placeholder="Логин" class="registr-user-input-surname @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">

                                    {{-- <input id="username" type="username" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ old('username') }}" autocomplete="username">
                                    <input class="registr-user-input-surname" type="text" name="name" id="name" placeholder="Фамилия" > --}}
                                </div>
                                    <span class="invalid-feedback" role="alert">
                                        @error('username')
                                            <strong>{{ $message }}</strong>
                                        @enderror
                                    </span>                                    
                                <div class="registr-login">
                                    <img src="{{ asset("svg/IMG/smail.svg")}}" alt="smail" class="registr-icon-smail-login">
                                    <input id="email" type="email" placeholder="Почта" class="registr-user-input-login @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">

                                    {{-- <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email">
                                    <input class="registr-user-input-login" type="text" name="name" id="name" placeholder="Логин" > --}}
                                </div>
                                    <span class="invalid-feedback" role="alert">
                                        @error('email')
                                            <strong>{{ $message }}</strong>
                                        @enderror
                                    </span>                                    
                                <div class="registr-zamok2">
                                    <img src="{{ asset("svg/IMG/zamok.svg")}}" alt="zamok" class="registr-icon-zamok2">
                                    <input id="password" type="password"  placeholder="Пароль" class="registr-zamok-input @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                    {{-- <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new-password">
                                    <input class="registr-zamok-input" type="password" name="name" id="name" placeholder="Пароль"> --}}
                                </div>
                                    <span class="invalid-feedback" role="alert">
                                        @error('password')
                                            <strong>{{ $message }}</strong>
                                        @enderror
                                    </span>                                    
                                <div class="registr-zamok2">
                                    <img src="{{ asset("svg/IMG/zamok.svg")}}" alt="zamok" class="registr-icon-zamok22">
                                    <input id="password-confirm" type="password" placeholder="Повторите пароль" class="registr-zamok-input" name="password_confirmation" autocomplete="new-password">

                                    {{-- <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                    <input class="registr-zamok-input" type="password" name="name" id="name" placeholder="Подтвердить пароль"> --}}
                                </div>
                                <div class="registr-remember2">
                                    <div class="regstr-radio-check2">   
                                        <input type="radio" class="radio-no2" id="no2" name="remember" value="no" checked>
                                        <label for="no2"><i class="fa fa-times"></i></label>  
                                        <input type="radio" class="radio-yes2" id="yes2" name="remember" value="yes">
                                        <label for="yes2"><i class="fa fa-check"></i></label>
                                        <span class="switch-selection2"></span>
                                    </div>
                                        <span class="check-yes">Я согдасен(-a) с</span>
                                        <span class="registr-terms">условиями использования.</span>	
                                </div>				
                                <div class="regstr-reg">
                                    <input class="registr-reg-input" type="submit" value="Зарегистрироваться" />
                                </div>
                            </form>

                    </div>
                </div>
            </div>
            <br>
        </section>
    @else
        <section class="login" >
            <div class="login-on">
                <div>
                    Рады Вас видеть  
                </div>                   
                <div class="login-on-profile">
                    <div class="img-profile"></div>

                    {{-- background-size: cover;
                    background-repeat: no-repeat;
                    background-position: center;
                    background-image: url("https://mdbcdn.b-cdn.net/img/Photos/Slides/img%20(15).webp");
                    background-size: cover; --}}
                  
                    {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/Slides/img%20(15).webp" class="img-profile" alt="Profile"/> --}}
                    <a class="nav-link"  href="{{route ( 'profile.show', ['user'=>Auth::user()->id])}}">{{ Auth::user()->username }}</a>
                </div>                      

            </div>
            <div class="login-off" >
                <form id="logout-form" action="{{ route('logout') }}" method="POST" >
                    @csrf
                    <input class="registr-entrance-input login-bt-off" type="submit" value="Выйти" />
                </form>                
            </div>
        </section>
    @endguest
    </div>
<hr>
<div class="wrap">
    <!-- навигация -->
    @section('navigation')
        <x-header.navigation></x-header.navigation>
    @show 
</div>
<hr>