@extends('master')
@section('guest')
    <title>Resto - Inscription client</title>
    
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

        /* Section principale */
        .register-section {
            padding: 80px 0;
            background-color: #f8f9fa;
            position: relative;
        }

        /* Pattern d'arrière-plan */
        .pattern-bg {
            position: relative;
        }

        .pattern-bg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%2310b981' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
        }

        /* Carte d'inscription */
        .register-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px var(--shadow-color);
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
            transform: translateY(0);
            transition: all 0.3s ease;
        }

        .register-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.2);
        }

        /* En-tête de la carte */
        .register-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            padding: 25px 30px;
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .register-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        }

        .register-header h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
            position: relative;
        }

        .register-header h3::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: -8px;
            width: 40px;
            height: 3px;
            background-color: white;
            border-radius: 3px;
            transform: translateX(-50%);
        }

        /* Corps de la carte */
        .register-body {
            padding: 30px;
        }

        /* Formulaire */
        .form-section-title {
            color: var(--primary-dark);
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-light);
            position: relative;
        }

        .form-section-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: -2px;
            width: 60px;
            height: 2px;
            background-color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control {
            height: 50px;
            padding: 10px 20px 10px 50px;
            font-size: 16px;
            border: 2px solid #e9ecef;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-light);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .form-group i {
            position: absolute;
            left: 16px;
            top: 16px;
            font-size: 18px;
            color: var(--primary-color);
            z-index: 2;
        }

        /* Alert pour les erreurs */
        .alert-danger {
            background-color: #fee2e2;
            color: #b91c1c;
            border: none;
            border-radius: 10px;
            padding: 15px 20px;
            margin-bottom: 25px;
        }

        .alert-danger ul {
            padding-left: 20px;
        }

        .alert-danger li {
            margin-bottom: 5px;
        }

        /* Lien de connexion */
        .login-link {
            text-align: center;
            margin: 20px 0;
            color: #6b7280;
        }

        .login-link a {
            color: var(--primary-color);
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .login-link a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Bouton de soumission */
        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px var(--shadow-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(16, 185, 129, 0.25);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Animation d'icône */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .form-group i {
            transition: all 0.3s ease;
        }

        .form-control:focus + i {
            color: var(--primary-hover);
            animation: pulse 1s infinite;
        }
    </style>

    <!-- Page Title Section -->
    <div class="register-section pattern-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="register-card">
                        <div class="register-header">
                            <h3><i class="fas fa-user-plus mr-2"></i> Créer un compte</h3>
                        </div>
                        <div class="register-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="post" action="{{ route('client.register.create') }}">
                                @csrf
                                <h6 class="form-section-title">Détails personnels</h6>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="Nom complet *" name="name" type="text" required>
                                    <i class="fas fa-user"></i>
                                </div>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="Adresse email *" name="email" type="email" required>
                                    <i class="fas fa-envelope"></i>
                                </div>
                                
                                <div class="form-group">
                                    <input class="form-control" placeholder="Mot de passe *" name="password" type="password" required>
                                    <i class="fas fa-lock"></i>
                                </div>
                                
                                <div class="login-link">
                                    Vous avez déjà un compte ? <a href="{{ route('client_login_form') }}">Connexion</a>
                                </div>

                                <button type="submit" class="submit-btn">
                                    <i class="fas fa-paper-plane mr-2"></i> S'inscrire maintenant
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection