<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Resto - Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
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
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets-login/css/bootstrap.min.css') }}">
    
    <!-- Main CSS -->
    <link rel="stylesheet" href="{{ asset('assets-login/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets-login/css/admin.css') }}">

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
            --admin-primary: #064e3b; /* Couleur plus foncée pour l'admin */
            --admin-secondary: #047857; /* Couleur secondaire pour l'admin */
            --admin-highlight: #10b981; /* Couleur de surbrillance */
        }

        /* Styles généraux */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        /* Style de la page de connexion */
        .account-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-wrapper {
            width: 100%;
            min-height: 100vh;
        }

        .bg-pattern-style {
            background-image: url("{{ asset('assets-login/img/bg-admin.jpg') }}");
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .bg-pattern-style::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.92) 0%, rgba(4, 120, 87, 0.92) 100%);
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
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            position: relative;
            border-top: 5px solid var(--admin-highlight);
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
            font-size: 1.5rem;
            color: var(--admin-highlight);
            transition: all 0.3s ease;
        }

        .home-icon:hover {
            color: var(--admin-primary);
            transform: translateX(-3px);
        }

        .login-header h3 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 10px;
            text-align: center;
        }

        .login-header h3 span {
            color: var(--admin-highlight);
            position: relative;
        }

        .login-header h3 span::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--admin-highlight);
            border-radius: 3px;
        }

        .login-header p {
            color: #6c757d;
            font-size: 1rem;
            margin-bottom: 0;
            text-align: center;
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
            border: 2px solid #e9ecef;
            padding: 0 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--admin-highlight);
            box-shadow: 0 0 0 0.25rem rgba(4, 120, 87, 0.15);
        }

        .pass-group {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 15px;
            cursor: pointer;
            color: #6c757d;
        }

        .login-btn {
            background: linear-gradient(135deg, var(--admin-secondary) 0%, var(--admin-primary) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            height: 50px;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 4px 10px rgba(4, 120, 87, 0.25);
            transition: all 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(4, 120, 87, 0.3);
            background: linear-gradient(135deg, var(--admin-highlight) 0%, var(--admin-secondary) 100%);
            color: white;
        }

        .forgot-link {
            color: var(--admin-secondary);
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 15px;
        }

        .forgot-link:hover {
            color: var(--admin-primary);
        }

        .dont-have {
            margin-top: 25px;
            font-size: 0.95rem;
            color: #6c757d;
        }

        .dont-have a {
            color: var(--admin-secondary);
            font-weight: 500;
            margin-left: 5px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .dont-have a:hover {
            color: var(--admin-primary);
            text-decoration: underline;
        }

        /* Badge admin pour indiquer privilèges élevés */
        .admin-badge {
            background-color: var(--admin-primary);
            color: white;
            font-size: 0.75rem;
            padding: 3px 8px;
            border-radius: 20px;
            position: absolute;
            top: -10px;
            right: -10px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .admin-badge i {
            font-size: 0.7rem;
        }

        /* Effet de pulsation légère sur le badge */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .admin-badge {
            animation: pulse 2s infinite;
        }

        /* Responsive */
        @media (max-width: 767px) {
            .login-right {
                padding: 30px 20px;
            }
            
            .login-header h3 {
                font-size: 1.8rem;
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
                        <div class="admin-badge">
                        </div>
                        <div class="login-right">
                            <div class="login-header">
                                <a href="/" class="home-icon"><i class="fas fa-arrow-circle-left"></i></a>

                                <h3>Login <span>Admin</span></h3>
                                <p class="text-muted">Accéder à votre tableau de bord</p>
                            </div>
                            <form action="{{ route('admin.login') }}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label class="form-control-label">Email Addresse</label>
                                    <input type="email" class="form-control" name="email">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Mot de passe</label>
                                    <div class="pass-group">
                                        <input type="password" class="form-control pass-input" name="password">
                                        {{-- <span class="fas fa-eye toggle-password"></span> --}}
                                    </div>
                                </div>

                                {{-- <div class="text-end">
                                    <a class="forgot-link" href="forgot-password.html">Forgot Password ?</a>
                                </div> --}}
                                <button class="btn btn-primary login-btn" type="submit">Login</button>
                                {{-- <div class="text-center dont-have">Don't have an account? <a href="{{ route('admin.register') }}">Register</a></div> --}}
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

</body>
</html>