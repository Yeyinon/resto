<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Resto - Client Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">

    <!-- Google Web Font -->
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

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets-login/css/bootstrap.min.css') }}">

    <!-- Fontawesome CSS -->
    <link rel="stylesheet" href="{{ asset('assets-login/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-login/plugins/fontawesome/css/all.min.css') }}">

    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets-login/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-login/css/client.css') }}">

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

        body {
            font-family: 'Poppins', sans-serif;
        }

        .bg-pattern-style {
            background-image: url("{{ asset('assets-login/img/bg-pattern.jpg') }}");
            background-size: cover;
            background-position: center;
            position: relative;
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .bg-pattern-style::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(6, 95, 70, 0.9) 0%, rgba(16, 185, 129, 0.85) 100%);
            z-index: 1;
        }

        .content {
            position: relative;
            z-index: 2;
            width: 100%;
            padding: 30px 15px;
        }

        .account-content {
            max-width: 500px;
            margin: 0 auto;
        }

        .account-box {
            background-color: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .login-right {
            padding: 40px;
        }

        .login-header {
            margin-bottom: 30px;
            position: relative;
        }

        .home-icon {
            position: absolute;
            top: 0;
            left: 0;
            font-size: 24px;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        .home-icon:hover {
            color: var(--primary-dark);
            transform: translateX(-5px);
        }

        .login-header h3 {
            color: var(--text-dark);
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
            text-align: center;
        }

        .login-header h3 span {
            color: var(--primary-color);
        }

        .login-header p {
            color: #6b7280;
            text-align: center;
            margin-bottom: 0;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-control-label {
            font-weight: 500;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            height: 50px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            padding: 10px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .pass-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-weight: 500;
            width: 100%;
            font-size: 16px;
            height: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px var(--shadow-color);
            margin-top: 10px;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-color);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
        }

        .dont-have {
            margin-top: 25px;
            color: #6b7280;
            font-size: 15px;
        }

        .dont-have a {
            color: var(--primary-color);
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .dont-have a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .form-control::placeholder {
            color: #9ca3af;
        }

        /* Animation légère pour le formulaire */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-right {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Responsive adjustments */
        @media (max-width: 767px) {
            .login-right {
                padding: 30px 20px;
            }
            
            .login-header h3 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body class="account-page">

    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Page Content -->
        <div class="bg-pattern-style">
            <div class="content">

                <!-- Login Tab Content -->
                <div class="account-content">
                    <div class="account-box">
                        <div class="login-right">
                            <div class="login-header">
                                <a href="/" class="home-icon"><i class="fas fa-arrow-circle-left"></i></a>
                                <h3>Login <span>Client</span></h3>
                                <p class="text-muted">Accéder à votre tableau de bord</p>
                            </div>

                            <form action="{{ route('client.login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-control-label">Email Addresse</label>
                                    <input type="email" class="form-control" name="email" placeholder="Entrez votre email">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Mot de passe</label>
                                    <div class="pass-group">
                                        <input type="password" class="form-control pass-input" name="password" placeholder="Entrez votre mot de passe">
                                        <span class="fas fa-eye toggle-password"></span>
                                    </div>
                                </div>

                                <button class="btn btn-primary login-btn" type="submit">Se connecter</button>
                                <div class="text-center dont-have">Vous n'avez pas de compte ? <a href="{{ route('client.register') }}">S'inscrire</a></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Login Tab Content -->

            </div>
        </div>
        <!-- /Page Content -->

    </div>
    <!-- /Main Wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('assets-login/js/jquery-3.6.0.min.js') }}"></script>

    <!-- Bootstrap Core JS -->
    <script src="{{ asset('assets-login/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Custom JS -->
    <script src="{{ asset('assets-login/js/script.js') }}"></script>
    
    <!-- Password Toggle Functionality -->
    <script>
        $(document).ready(function() {
            $(".toggle-password").click(function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $(this).closest('.pass-group').find('.pass-input');
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        });
    </script>
</body>
</html>