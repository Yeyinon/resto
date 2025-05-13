@extends('restaurant.master')
@section('restaurant')
    <div class="content-wrapper">
        <div class="tables-container">
            <!-- En-tête avec effet dégradé -->
            <div class="header-banner">
                <div class="header-content">
                    <h1 class="profile-title">Ajouter une Table</h1>
                    
                    <!-- Fil d'ariane amélioré -->
                    <div class="breadcrumb-modern">
                        <a href="{{ route('restaurant.dashboard') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Ajouter une table</span>
                    </div>
                </div>
            </div>

            <!-- Carte principale du formulaire avec effet d'ombre -->
            <div class="tables-card">
                <div class="tables-header">
                    <div class="tables-icon-container">
                        <div class="tables-icon-circle">
                            <i class="fas fa-plus"></i>
                        </div>
                    </div>
                    <h2 class="tables-subtitle">Nouvelle Table</h2>
                    <p class="tables-description">Créez une nouvelle table pour votre restaurant</p>
                </div>

                <div class="tables-divider"></div>
                
                <form method="post" action="{{ route('restaurant.table.store') }}" class="table-form">
                    @csrf
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="table-number">
                                    <i class="fas fa-hashtag form-icon"></i> Numéro de table
                                </label>
                                <input type="number" id="table-number" class="form-control" name="number" placeholder="Entrez le numéro de la table">
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="restaurant_id" value="{{ Auth::guard('restaurant')->user()->id }}">
                    <input type="hidden" name="status" value="Disponible">
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="guest-number">
                                    <i class="fas fa-users form-icon"></i> Nombre d'invités
                                </label>
                                <input type="number" id="guest-number" class="form-control" name="guest_number" placeholder="Nombre maximum d'invités">
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-col">
                            <div class="form-group">
                                <label for="table-location">
                                    <i class="fas fa-map-marker-alt form-icon"></i> Emplacement
                                </label>
                                <div class="custom-select">
                                    <select id="table-location" name="location" class="form-control">
                                        <option value="Sur la terrasse">Sur la terrasse</option>
                                        <option value="A l'intérieur">A l'intérieur</option>
                                    </select>
                                    <i class="fas fa-chevron-down select-arrow"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <a href="{{ route('restaurant.tables') }}" class="btn-cancel">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                        <button class="btn-save" type="submit">
                            <i class="fas fa-check"></i> Créer la table
                        </button>
                    </div>
                </form>
                
                <div class="card-footer">
                    <i class="fas fa-info-circle"></i> Les tables créées seront disponibles immédiatement
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
            --danger-color: #ef4444;
            --danger-dark: #b91c1c;
            --danger-light: #fee2e2;
            --warning-color: #f59e0b;
            --table-header: #f1f5f9;
            --table-border: #e2e8f0;
            --table-hover: #f8fafc;
        }

        /* Styles généraux */
        .content-wrapper {
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        
        .tables-container {
            max-width: 900px;
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

        /* Carte principale du formulaire */
        .tables-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px var(--shadow-color);
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }
        
        .tables-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .tables-icon-container {
            margin-bottom: 15px;
        }
        
        .tables-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }
        
        .tables-icon-circle i {
            font-size: 2rem;
            color: white;
        }
        
        .tables-subtitle {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .tables-description {
            color: #6b7280;
            font-size: 0.95rem;
        }
        
        .tables-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            margin: 15px 0 30px;
        }

        /* Formulaire */
        .table-form {
            max-width: 700px;
            margin: 0 auto;
        }
        
        .form-row {
            margin-bottom: 25px;
        }
        
        .form-col {
            width: 100%;
        }
        
        .form-group {
            margin-bottom: 5px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text-dark);
            font-size: 0.95rem;
        }
        
        .form-icon {
            color: var(--primary-color);
            margin-right: 5px;
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
        
        /* Style personnalisé pour le select */
        .custom-select {
            position: relative;
        }
        
        .custom-select select {
            width: 100%;
            appearance: none;
            -webkit-appearance: none;
            padding-right: 30px;
        }
        
        .select-arrow {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            pointer-events: none;
        }
        
        /* Boutons d'action */
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        
        .btn-cancel {
            background-color: #e5e7eb;
            color: #4b5563;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        
        .btn-cancel:hover {
            background-color: #d1d5db;
            text-decoration: none;
            color: #374151;
        }
        
        .btn-save {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 25px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }
        
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-color);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
        }
        
        .btn-cancel i, .btn-save i {
            margin-right: 8px;
        }

        /* Footer de la carte */
        .card-footer {
            margin-top: 20px;
            padding-top: 15px;
            color: #6b7280;
            font-size: 0.85rem;
            border-top: 1px solid var(--table-border);
            text-align: center;
        }
        
        .card-footer i {
            margin-right: 5px;
            color: var(--warning-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-banner {
                padding: 20px;
            }
            
            .profile-title {
                font-size: 1.8rem;
            }
            
            .tables-card {
                padding: 20px;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn-cancel, .btn-save {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endsection