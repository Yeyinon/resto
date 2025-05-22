<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Resto - Découvrir et réserver les meilleurs restaurants au meilleur prix">
    <meta name="author" content="Resto">

    <!-- GOOGLE WEB FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous">
    <link rel="preload" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700&display=swap" as="fetch" crossorigin="anonymous">
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

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <!-- BASE CSS -->
    <link href="{{ asset('assets-home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/style.css') }}" rel="stylesheet">
    <!-- SPECIFIC CSS -->
    <link href="{{ asset('assets-home/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/detail-page.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/booking-sign_up.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/submit.css') }}" rel="stylesheet">

    <title>@yield('title', 'Resto ')</title>

    <style>
        /* Variables pour les couleurs */
        :root {
            --primary-color: #10b981;
            --primary-dark: #065f46;
            --primary-light: #d1fae5;
            --primary-hover: #059669;
            --text-dark: #064e3b;
            --text-light: #f0fdfa;
            --border-color: #99f6e4;
            --background-light: #f8fffc;
            --shadow-color: rgba(16, 185, 129, 0.15);
        }

        /* Styles généraux */
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        /* Layout principal */
        .main-content {
            min-height: calc(100vh - 350px); /* Assure que le contenu prend au moins toute la hauteur moins le header/footer */
            padding: 20px 0;
        }
        
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header amélioré */
        .header.clearfix {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            box-shadow: 0 4px 10px var(--shadow-color);
            padding: 15px 0;
        }

        .header a, .header span {
            color: var(--text-light);
            transition: all 0.2s ease;
        }

        .header a:hover {
            color: white;
            text-decoration: none;
        }

        /* Page title section */
        .page-title-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 40px 0;
            color: white;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .page-title-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            transform: rotate(-30deg);
        }

        .page-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .breadcrumb-modern {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1rem;
            position: relative;
            z-index: 1;
        }
        
        .breadcrumb-item {
            color: rgba(255,255,255,0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        
        .breadcrumb-item:hover {
            color: white;
            text-decoration: none;
        }
        
        .breadcrumb-item.active {
            font-weight: 600;
            color: white;
        }
        
        .breadcrumb-separator {
            margin: 0 12px;
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Cards pour le contenu */
        .content-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px var(--shadow-color);
            padding: 30px;
            margin-bottom: 30px;
        }

        /* Footer amélioré */
        footer {
            background: linear-gradient(135deg, var(--primary-dark) 0%, #043a30 100%);
            color: var(--text-light);
            padding-top: 40px;
        }

        footer h3 {
            color: white;
            font-weight: 600;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }

        footer h3:after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 3px;
        }

        footer ul {
            list-style: none;
            padding-left: 0;
        }

        footer ul li {
            margin-bottom: 12px;
        }

        footer a {
            color: rgba(255,255,255,0.8);
            transition: all 0.2s ease;
        }

        footer a:hover {
            color: white;
            text-decoration: none;
        }

        /* Boutons */
        .btn-primary-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }
        
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-color);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .btn-primary-custom i {
            margin-right: 8px;
        }
    </style>
    
    @yield('styles')
</head>

<body>
    <!-- Header -->
    <header class="header clearfix element_to_stick">
        <div class="container">
            <div id="logo">
                <a href="/">
                    <img src="{{ asset('assets-home/img/resto2.png') }}" width="100" height="30" alt="" class="logo_normal">
                    <img src="{{ asset('assets-home/img/resto.png') }}" width="100" height="30" alt="" class="logo_sticky">
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
                            </a><br>
                            <div class="dropdown-menu">
                                <div class="dropdown-menu-content">
                                    <ul>
                                        <li><a href="{{ route('client.logout') }}"><i class="icon_key"></i>Se
                                                déconnecter</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            @endauth
            <a href="#0" class="open_close">
                <i class="icon_menu"></i><span>Menu</span>
            </a>
            <nav class="main-menu">
                <div id="header_menu">
                    <a href="#0" class="open_close">
                        <i class="icon_close"></i><span>Menu</span>
                    </a>
                    <a href="/"><img src="{{ asset('assets-home/img/resto2.png') }}" width="140" height="35" alt=""></a>
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
                        @endauth
                    </li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- /Header -->

    <!-- Main Content -->
    <div class="page-wrapper">
                @yield('guest')
            </div>

    <!-- Footer -->
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

    @yield('scripts')
</body>

</html>