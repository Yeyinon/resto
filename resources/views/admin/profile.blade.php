
@extends('admin.master')
@section('admin')
    <div class="content-wrapper">
        <div class="profile-container">
            <!-- En-tête avec effet dégradé -->
            <div class="header-banner">
                <div class="header-content">
                    <h1 class="profile-title">Mon Profil</h1>
                    
                    <!-- Fil d'ariane amélioré -->
                    <div class="breadcrumb-modern">
                        <a href="#" class="breadcrumb-item">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Mon Profil</span>
                    </div>
                </div>
            </div>

            <!-- Carte principale du profil avec effet d'ombre -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-icon-container">
                        <div class="profile-icon-circle">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <h2 class="profile-subtitle">Détails du profil</h2>
                    <p class="profile-description">Informations personnelles de votre compte</p>
                </div>

                <div class="profile-divider"></div>
                
                <div class="profile-form">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group profile-photo-container">
                                <label for="photo">
                                    <i class="fas fa-camera form-icon"></i> Votre photo
                                </label>
                                <div class="profile-photo-frame">
                                    <img src="{{ asset('img/manager.png') }}" alt="Photo de profil" class="profile-photo">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="name">
                                        <i class="fas fa-signature form-icon"></i> Nom
                                    </label>
                                    <input type="text" id="name" class="form-control" disabled value="{{ Auth::guard('admin')->user()->name }}">
                                </div>
                                
                                <div class="form-group">
                                    <label for="email">
                                        <i class="fas fa-envelope form-icon"></i> Email
                                    </label>
                                    <input type="email" id="email" class="form-control" disabled value="{{ Auth::guard('admin')->user()->email }}">
                                </div>
                            </div>
                            
                            <!-- Vous pouvez ajouter d'autres champs ici si nécessaire -->
                            
                            <div class="form-action">
                                <button type="button" class="btn-edit">
                                    <i class="fas fa-edit"></i> Modifier le profil
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        .content-wrapper {
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Style de l'en-tête avec dégradé */
        .header-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px var(--shadow-color);
            position: relative;
            overflow: hidden;
        }
        
        .header-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
            transform: rotate(-30deg);
        }
        
        .header-content {
            position: relative;
            z-index: 1;
        }
        
        .profile-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Fil d'ariane amélioré */
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1rem;
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

        /* Carte principale du profil */
        .profile-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px var(--shadow-color);
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }
        
        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .profile-icon-container {
            margin-bottom: 15px;
        }
        
        .profile-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }
        
        .profile-icon-circle i {
            font-size: 2rem;
            color: white;
        }
        
        .profile-subtitle {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .profile-description {
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        .profile-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            margin: 15px 0 30px;
        }

        /* Formulaire */
        .profile-form {
            padding: 10px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }
        
        .form-icon {
            color: var(--primary-color);
            margin-right: 5px;
        }
        
        .text-muted {
            font-size: 0.85rem;
            color: #6b7280;
            font-weight: normal;
        }
        
        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--background-light);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }
        
        .form-control:disabled {
            background-color: #f9fafb;
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        /* Style pour la photo de profil */
        .profile-photo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        
        .profile-photo-frame {
            width: 170px;
            height: 170px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid var(--primary-light);
            box-shadow: 0 5px 15px var(--shadow-color);
            margin: 10px auto;
            position: relative;
        }
        
        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .form-action {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }
        
        .btn-edit {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }
        
        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-color);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
        }
        
        .btn-edit i {
            margin-right: 8px;
        }
        
        /* Responsive pour le layout principal */
        @media (max-width: 767px) {
            .row {
                flex-direction: column;
            }
            
            .col-md-4 {
                max-width: 100%;
                margin-bottom: 30px;
            }
            
            .col-md-8 {
                max-width: 100%;
            }
        }
    </style>
@endsection
```