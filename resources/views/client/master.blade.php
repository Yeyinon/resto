<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Foogra - Discover & Book the best restaurants at the best price">
    <meta name="author" content="Ansonika">

    <!-- Favicons-->
    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/favicon.ico') }}">

    <!-- GOOGLE WEB FONT -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('assets-home/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/style.css') }}" rel="stylesheet">

    <!-- SPECIFIC CSS -->
    <link href="{{ asset('assets-home/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/detail-page.css') }}" rel="stylesheet">
    <link href="{{ asset('assets-home/css/booking-sign_up.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #e8f7f1;
            font-family: 'Poppins', sans-serif;
        }

        header.header_in {
            background-color: #e8f7f1;
            color: #fff;
        }
    </style>
</head>

<body>
    <header class="header_in clearfix">
        <div class="container">
            <div id="logo">
                <a href="/">

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


        @yield('client')

    </div>
    <!-- /Page Wrapper -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <h3 data-bs-target="#collapse_1">Liens rapides</h3>
                    <div class="collapse dont-collapse-sm links" id="collapse_1">
                        <ul>
                            <li><a href="{{ route('restaurant.register') }}">Êtes-vous un restaurant ? Pourquoi
                                    soumettre à
                                    Resto?</a></li>
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
                            <li><i class="icon_mail_alt"></i><a href="#0">restorant.application@gmail.com</a></li>
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
    <!--/footer-->

    <div id="toTop"></div><!-- Back to top button -->

    <div class="layer"></div><!-- Opacity Mask Menu Mobile -->

    <!-- SPECIFIC SCRIPTS -->
    <script src="{{ asset('assets-home/js/sticky_sidebar.min.js') }}"></script>
    <script src="{{ asset('assets-home/js/specific_detail.js') }}"></script>
    <script src="{{ asset('assets-home/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('assets-home/js/datepicker_func_1.js') }}"></script>


    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('assets-home/js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('assets-home/js/common_func.js') }}"></script>
    <script src="{{ asset('assets-home/assets/validate.js') }}"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('assets-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Core plugin JavaScript-->
    <script src="{{ asset('assets-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <!-- Page level plugin JavaScript-->
    <script src="{{ asset('assets-admin/vendor/chart.js/Chart.js') }}"></script>
    <script src="{{ asset('assets-admin/vendor/datatables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets-admin/vendor/datatables/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets-admin/vendor/jquery.magnific-popup.min.js') }}"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{ asset('assets-admin/js/admin.js') }}"></script>
    <!-- Custom scripts for this page-->
    <script src="{{ asset('assets-admin/js/admin-charts.js') }}"></script>

    <!-- TYPE EFFECT -->
    <script src="{{ asset('assets-home/js/typed.min.js') }}"></script>
    <script>
        var typed = new Typed('.element', {
            strings: ["au meilleur mes reservations", "avec une nourriture unique", "avec un bel emplacement"],
            startDelay: 10,
            loop: true,
            backDelay: 2000,
            typeSpeed: 50
        });
    </script>

</body>

</html>
