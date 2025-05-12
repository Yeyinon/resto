<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Foogra - Discover & Book the best restaurants at the best price">
    <meta name="author" content="Ansonika">

    <!-- GOOGLE WEB FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap"
        as="fetch" crossorigin="anonymous">
    <script type="text/javascript">
        ! function(e, n, t) {
            "use strict";
            var o = "https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap",
                r = "__3perf_googleFonts_c2536";

            function c(e) {
                (n.head || n.body).appendChild(e)
            }

            function a() {
                var e = n.createElement("link");
                e.href = o, e.rel = "stylesheet", c(e)
            }

            function f(e) {
                if (!n.getElementById(r)) {
                    var t = n.createElement("style");
                    t.id = r, c(t)
                }
                n.getElementById(r).innerHTML = e
            }
            e.FontFace && e.FontFace.prototype.hasOwnProperty("display") ? (t[r] && f(t[r]), fetch(o).then(function(e) {
                return e.text()
            }).then(function(e) {
                return e.replace(/@font-face {/g, "@font-face{font-display:swap;")
            }).then(function(e) {
                return t[r] = e
            }).then(f).catch(a)) : a()
        }(window, document, localStorage);
    </script>
    
    <!-- Custom CSS style for green background -->
    <style>
        body {
            background-color: #e8f7f1;
            font-family: 'Poppins', sans-serif;
        }
    </style>

    <!-- BASE CSS -->
    <link href="{{ asset('assets-home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/style.css') }}" rel="stylesheet">
    <!-- SPECIFIC CSS -->
    <link href="{{ asset('assets-home/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/detail-page.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/booking-sign_up.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/submit.css') }}" rel="stylesheet">
</head>

<body>
    <header class="header clearfix element_to_stick">
        <div class="container">
            <div id="logo">
                <a href="/">
                    <img src="{{ asset('assets-home/img/resto2.png') }}" width="100" height="30" alt=""
                        class="logo_normal">
                    <img src="{{ asset('assets-home/img/resto.png') }}" width="100" height="30" alt=""
                        class="logo_sticky">
                </a>
            </div>
            @guest('client')
                <ul id="top_menu">
                    <li><a href="{{ route('client_login_form') }}" class="login">Login</a></li>
                </ul>
            @endguest
            @auth('client')
                <ul id="top_menu" class="drop_user">
                    <li>
                        <div class="dropdown user clearfix">
                            <a href="#" data-bs-toggle="dropdown">
                                <figure><img src="{{ asset('img/client_user.png') }}" alt=""></figure>
                                <span>{{ Auth::guard('client')->user()->name }}</span><br><br>
                                <span>{{ Auth::guard('client')->user()->yums == 0 ? 0 : Auth::guard('client')->user()->yums }}
                                    Yums</span>&nbsp;&nbsp;
                            </a></br>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-content">
                                    <ul>
                                        <li><a href="{{ route('client.logout') }}"><i class="icon_key"></i>Se
                                                déconnecter</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- /dropdown -->
                    </li>
                </ul>
            @endauth
            <!-- /top_menu -->
            <a href="#0" class="open_close">
                <i class="icon_menu"></i><span>Menu</span>
            </a>
            <nav class="main-menu">
                <div id="header_menu">
                    <a href="#0" class="open_close">
                        <i class="icon_close"></i><span>Menu</span>
                    </a>
                    <a href="/"><img src="{{ asset('assets-home/img/resto2.png') }}" width="140"
                            height="35" alt=""></a>
                </div>
                <ul>
                    <li class="submenu">
                        @guest('client')
                            <a href="#0" class="show-submenu">Connexion</a>
                            <ul>
                                <li class="third-level"><a href="#0">Espace <strong>Client!</strong></a>
                                    <ul>
                                        <li><a href="{{ route('client_login_form') }}">Connexion</a></li>
                                        <li><a href="{{ route('client.register') }}">Créer un compte</a></li>
                                    </ul>
                                </li>
                                <li class="third-level"><a href="#0">Espace <strong>Restaurant!</strong></a>
                                    <ul>
                                        <li><a href="{{ route('login_form') }}">Connexion</a></li>
                                        <li><a href="{{ route('restaurant.register') }}">Enregistrez votre restaurant</a></li>
                                    </ul>
                                </li>
                                <li class="third-level"><a href="#0">Espace <strong>Admin!</strong></a>
                                    <ul>
                                        <li><a href="{{ route('admin_login_form') }}">Connexion</a></li>
                                    </ul>
                                </li>
                            </ul>
                        <li><a href="{{ route('restaurant.register') }}" target="_parent">Pourquoi Resto ?</a></li>
                        <li><a href="{{ route('view_all') }}" target="_parent">Découvrez les restaurants</a></li>
                        @endguest
                        @auth('client')
                        <li><a href="{{ route('client.reservations') }}" target="_parent">Mes reservations</a></li>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>
    <div class="page-wrapper">
        @yield('guest')
    </div>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_1">Liens rapides</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_1">
                        <ul>
                            <li><a href="{{ route('restaurant.register') }}">Êtes-vous un restaurant ? Pourquoi
                                    soumettre à Resto?</a></li>
                            <li><a href="{{ route('view_all') }}">Découvrez les restaurants disponibles</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_2">Connexion</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_2">
                        <ul>
                            <li><a href="{{ route('client_login_form') }}">Client</a></li>
                            <li><a href="{{ route('login_form') }}">Proprietaire d'un restaurant</a></li>
                            <li><a href="{{ route('admin_login_form') }}">administrateur</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_3">Contacts</h3>
                    <div class="collapse dont-collapse-sm contacts" id="collapse_3">
                        <ul>
                        <li><i class="icon_house_alt"></i>Axel&Bryan<br>Benin</li>
                            <li><i class="icon_mobile"></i>+2290140750121</li>
                            <li><i class="icon_mail_alt"></i><a href="#0">restorant.application@mail.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="collapse dont-collapse-sm" id="collapse_4">
                        <div class="follow_us"><br>
                            <h5>© 2025 RESTO - TOUS LES DROITS SONT RÉSERVÉS</h5>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /row-->
            <hr>
        </div>
    </footer>
    <!--/footer-->

    <div id="toTop"></div><!-- Back to top button -->

    <div class="layer"></div><!-- Opacity Mask Menu Mobile -->

    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('assets-home/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('assets-home/js/common_func.js') }}"></script>
    <script src="{{ asset('assets-home/assets/validate.js') }}"></script>

    <!-- TYPE EFFECT -->
    <script src="{{ asset('assets-home/js/typed.min.js') }}"></script>
    <script>
        var typed = new Typed('.element', {
            strings: ["au meilleur prix", "avec une nourriture unique", "avec un bel emplacement"],
            startDelay: 10,
            loop: true,
            backDelay: 2000,
            typeSpeed: 50
        });
    </script>
</body>

</html>