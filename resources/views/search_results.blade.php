<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Foogra - Discover & Book the best restaurants at the best price">
    <meta name="author" content="Ansonika">
    {{-- <title>Resto - Découvrez & Réservez</title> --}}

    {{-- <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}"> --}}


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
    <!-- BASE CSS -->
    <link href="{{ asset('assets-home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/style.css') }}" rel="stylesheet">
    <!-- SPECIFIC CSS -->
    <link href="{{ asset('assets-home/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/detail-page.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/booking-sign_up.css') }}" rel="stylesheet">

    <!-- ALTERNATIVE COLORS CSS -->
    <link href="#" id="colors" rel="stylesheet">
    <!-- SPECIFIC CSS -->
    <link href="{{ asset('assets-home/css/submit.css') }}" rel="stylesheet">
</head>
<header class="header clearfix element_to_stick" style="background-color: #0d1b2a;">
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
                    {{-- <li><a href="wishlist.html" class="wishlist_bt_top" title="Your wishlist">Your wishlist</a></li> --}}
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
    <main style="margin-top: 100px;">
        <div class="container">
            <div class="row">
                @foreach ($restaurants as $restaurant)
                    <div class="col-md-4">
                        <div class="strip">
                        <figure>
                            @if($restaurant->yums > 0)
                                <span class="ribbon off">+ {{ $restaurant->yums }} Yums</span>
                            @endif

                            @if($restaurant->image_path)
                                <!-- Utiliser l'image téléchargée par le restaurant si disponible -->
                                <img src="{{ asset($restaurant->image_path) }}" data-src="{{ asset($restaurant->image_path) }}"
                                    class="owl-lazy" alt="{{ $restaurant->name }}">
                            @else
                                <!-- Utiliser l'image par défaut si aucune image n'a été téléchargée -->
                                <img src="{{ asset('assets-home/img/detail_3.jpg') }}"
                                    data-src="{{ asset('assets-home/img/home_section_1.jpg') }}" class="owl-lazy"
                                    alt="{{ $restaurant->name }}">
                            @endif

                            <a href="client/book/{{ $restaurant->id }}" class="strip_info">
                                <small>{{ $restaurant->name }}</small>
                                <div class="item_title">
                                    <h3>{{ $restaurant->name }}</h3>
                                    <small>{{ $restaurant->location }}</small>
                                </div>
                            </a>
                        </figure>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
    <footer style="margin-top: 100px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_1">Liens rapides</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_1">
                        <ul>
                            {{-- <li><a href="{{ route('book') }}">Êtes-vous un restaurant ? Pourquoi
                                    soumettre à Resto?</a></li> --}}
                            <li><a href="{{ route('restaurant.register') }}">Êtes-vous un restaurant ? Pourquoi
                                    soumettre à Resto?</a></li>
                            <li><a href="{{ route('view_all') }}">Découvrez les restaurants disponibles</a></li>
                            {{-- <li><a href="help.html">Help</a></li>
							<li><a href="account.html">My account</a></li>
							<li><a href="blog.html">Blog</a></li>
							<li><a href="contacts.html">Contacts</a></li> --}}
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
                    {{-- <h3 data-bs-target="#collapse_4">Keep in touch</h3> --}}
                    <div class="collapse dont-collapse-sm" id="collapse_4">
                        {{-- <div id="newsletter">
							<div id="message-newsletter"></div>
							<form method="post" action="assets/newsletter.php" name="newsletter_form" id="newsletter_form">
								<div class="form-group">
									<input type="email" name="email_newsletter" id="email_newsletter" class="form-control" placeholder="Your email">
									<button type="submit" id="submit-newsletter"><i class="arrow_carrot-right"></i></button>
								</div>
							</form>
						</div> --}}
                        {{-- <div class="follow_us">
                            <h5>Suivez-nous</h5>
                            <ul>
                                <li><a href="#0"><img data-src="{{ asset('assets-home/img/facebook1.svg') }}"
                                            alt="" class="lazy"></a></li>
                            </ul>
                        </div> --}}
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
