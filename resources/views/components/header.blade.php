<header>
    <h1 class="hide">Фотоальбом</h1>
        <div class="wrap">
            <!-- логотип -->
            <div class="logotip">
                <a href="#" aria-label="Logotip"> 
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
            <section class="login">
                    <input type="radio" name="authorization" id="authorization-on" >
                    <label for="authorization-on" class="but-login" title="Вход">Войти</label>

                    <label for="authorization-off" class="but-login-off" title="Выход" ></label>
                    <input type="radio" name="authorization" id="authorization-off" checked >
                <div class="authorization-fon" >

                    <div class="authorization" >
                        <input type="radio" name="tabs" id="tab-1" checked style="display: none">
                        <input type="radio" name="tabs" id="tab-2" style="display: none">

                        <label for="tab-1" class="but-authorization" title="Авторизация">Авторизация</label>
                        <label for="tab-2" class="but-registration" title="Регистрация">Регистрация</label>	

                            <div  class="forma1">
                                <form  method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="registr-name">
                                        <img src="{{ asset("svg/IMG/smail.svg")}}" alt="smail" class="registr-icon-smail">
                                        <input class="registr-user-input" type="text" name="name" id="name" placeholder="Логин" >
                                    </div>
                                    <div class="registr-zamok">
                                        <img src="{{ asset("svg/IMG/zamok.svg")}}" alt="zamok" class="registr-icon-zamok">
                                        <input class="registr-zamok-input" type="password" name="name" id="name" placeholder="Пароль">
                                    </div>
                                    <div class="regstr-entrance">
                                        <input class="registr-entrance-input" type="submit" value="Войти" />
                                    </div>
                                    <div class="registr-remember">
                                        <div class="regstr-radio-check">   
                                            <input type="radio" class="radio-no" id="no" name="remember" value="no" checked>
                                            <label for="no"><i class="fa fa-times"></i></label>  
                                            <input type="radio" class="radio-yes" id="yes" name="remember" value="yes">
                                            <label for="yes"><i class="fa fa-check"></i></label>
                                            <span class="switch-selection"></span>
                                        </div>
                                            <span class="check-label">Запомнить меня</span>
                                            <span class="forgot-label">Забыли свой пароль?</span>	
                                    </div>
                                </form>
                            </div>
                        <div class="forma2" >
                                <form action="#">
                                    <div class="registr-gender">
                                        <p class="registr-gender-p">Обращение</p>
                                        <label>
                                            <input type="radio" name="title" value="men" checked>
                                            Г-н
                                        </label>
                                        <label>
                                            <input type="radio" name="title" value="woman">
                                            Г-жа
                                        </label>
                                    </div>
                                    <div class="registr-name">
                                        <img src="{{ asset("svg/IMG/id.svg")}}" alt="smail" class="registr-icon-identificati-name">
                                        <input class="registr-user-input-name" type="text" name="name" id="name" placeholder="Имя" >
                                    </div>	
                                    <div class="registr-surname">
                                        <img src="{{ asset("svg/IMG/id.svg")}}" alt="smail" class="registr-icon-surname">
                                        <input class="registr-user-input-surname" type="text" name="name" id="name" placeholder="Фамилия" >
                                    </div>
                                    <div class="registr-login">
                                        <img src="{{ asset("svg/IMG/smail.svg")}}" alt="smail" class="registr-icon-smail-login">
                                        <input class="registr-user-input-login" type="text" name="name" id="name" placeholder="Логин" >
                                    </div>
                                    <div class="registr-zamok2">
                                        <img src="{{ asset("svg/IMG/zamok.svg")}}" alt="zamok" class="registr-icon-zamok2">
                                        <input class="registr-zamok-input" type="password" name="name" id="name" placeholder="Пароль">
                                    </div>
                                    <div class="registr-zamok2">
                                        <img src="{{ asset("svg/IMG/zamok.svg")}}" alt="zamok" class="registr-icon-zamok22">
                                        <input class="registr-zamok-input" type="password" name="name" id="name" placeholder="Подтвердить пароль">
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