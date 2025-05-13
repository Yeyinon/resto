@extends('restaurant.master')
@section('restaurant')
    <div class="content-wrapper">
        <div class="menu-container">
            <!-- En-tête avec effet dégradé -->
            <div class="header-banner">
                <div class="header-content">
                    <h1 class="profile-title">Mes Menus</h1>
                    
                    <!-- Fil d'ariane amélioré -->
                    <div class="breadcrumb-modern">
                        <a href="{{ route('restaurant.dashboard') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Mes Menus</span>
                    </div>
                </div>
            </div>

            <!-- Bouton d'ajout de menu -->
            <div class="action-container">
                <form action="{{ route('restaurant.menus.create') }}" method="GET">
                    <button type="submit" class="btn-add">
                        <i class="fas fa-plus-circle"></i> Ajouter un menu
                    </button>
                </form>
            </div>

            <!-- Message de succès -->
            @if(session('success'))
                <div class="success-alert">
                    <i class="fas fa-check-circle alert-icon"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Grille des menus -->
            @if($menus->count() > 0)
                <div class="menus-grid">
                    @foreach($menus as $menu)
                        <div class="menu-card">
                            <div class="menu-header">
                                <h3 class="menu-name">{{ $menu->nom }}</h3>
                                <p class="menu-info">
                                    <i class="fas fa-utensils"></i> {{ $menu->plats->count() }} plat(s)
                                </p>
                            </div>
                            
                            <div class="menu-divider"></div>
                            
                            <!-- Carrousel horizontal de plats -->
                            <div class="plats-carousel-container">
                                <div class="plats-carousel">
                                    @foreach($menu->plats as $plat)
                                        <div class="plat-card">
                                            @if($plat->photo)
                                                <div class="plat-image-container">
                                                    <img src="{{ asset('storage/' . $plat->photo) }}" alt="{{ $plat->nom }}" class="plat-image">
                                                </div>
                                            @endif
                                            <div class="plat-details">
                                                <h4 class="plat-name">{{ $plat->nom }}</h4>
                                                <p class="plat-price">{{ $plat->prix }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                @if($menu->plats->count() > 2)
                                    <div class="carousel-indicators">
                                        <span class="carousel-indicator active"></span>
                                        <span class="carousel-indicator"></span>
                                        <span class="carousel-indicator"></span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Actions du menu -->
                            <div class="menu-actions">
                                <form action="{{ route('restaurant.menus.edit', $menu) }}" method="GET">
                                    <button type="submit" class="btn-edit">
                                        <i class="fas fa-pencil-alt"></i> Modifier
                                    </button>
                                </form>

                                <form action="{{ route('restaurant.menus.destroy', $menu) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce menu ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon-container">
                        <i class="fas fa-clipboard-list empty-icon"></i>
                    </div>
                    <p class="empty-text">Aucun menu enregistré</p>
                    <p class="empty-description">Commencez par ajouter votre premier menu</p>
                </div>
            @endif
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
        
        .menu-container {
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

        /* Container pour le bouton d'ajout */
        .action-container {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }

        /* Bouton d'ajout */
        .btn-add {
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
        
        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-color);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
        }
        
        .btn-add i {
            margin-right: 8px;
        }

        /* Message d'alerte */
        .success-alert {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
        }
        
        .alert-icon {
            color: var(--primary-color);
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Grille des menus */
        .menus-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        @media (max-width: 768px) {
            .menus-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Carte de menu */
        .menu-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px var(--shadow-color);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px var(--shadow-color);
        }
        
        .menu-header {
            padding: 20px 20px 10px;
            text-align: center;
        }
        
        .menu-name {
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .menu-info {
            color: #6b7280;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .menu-info i {
            margin-right: 5px;
            color: var(--primary-color);
        }
        
        .menu-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            margin: 0 20px 15px;
        }

        /* Carrousel de plats */
        .plats-carousel-container {
            position: relative;
            padding: 10px 0;
            margin-bottom: 15px;
        }
        
        .plats-carousel {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 5px 20px;
            scrollbar-width: none; /* Pour Firefox */
            -ms-overflow-style: none; /* Pour IE/Edge */
            gap: 15px;
            scroll-snap-type: x mandatory;
        }
        
        .plats-carousel::-webkit-scrollbar {
            display: none; /* Pour Chrome/Safari */
        }
        
        .plat-card {
            flex: 0 0 auto;
            width: 160px;
            background-color: var(--background-light);
            border-radius: 8px;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
            scroll-snap-align: start;
            border: 1px solid rgba(16, 185, 129, 0.1);
        }
        
        .plat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .plat-image-container {
            width: 100%;
            height: 100px;
            overflow: hidden;
            border-radius: 6px;
            margin-bottom: 8px;
        }
        
        .plat-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        
        .plat-card:hover .plat-image {
            transform: scale(1.05);
        }
        
        .plat-details {
            text-align: center;
        }
        
        .plat-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .plat-price {
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--primary-color);
        }
        
        .carousel-indicators {
            display: flex;
            justify-content: center;
            padding: 10px 0 0;
            gap: 8px;
        }
        
        .carousel-indicator {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #d1d5db;
            transition: all 0.3s ease;
        }
        
        .carousel-indicator.active {
            background-color: var(--primary-color);
            width: 24px;
            border-radius: 4px;
        }

        /* Actions du menu */
        .menu-actions {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 15px 20px 20px;
        }
        
        .btn-edit, .btn-delete {
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        
        .btn-edit {
            background-color: #3b82f6;
            color: white;
            border: none;
            box-shadow: 0 2px 5px rgba(59, 130, 246, 0.3);
        }
        
        .btn-edit:hover {
            background-color: #2563eb;
        }
        
        .btn-delete {
            background-color: #ef4444;
            color: white;
            border: none;
            box-shadow: 0 2px 5px rgba(239, 68, 68, 0.3);
        }
        
        .btn-delete:hover {
            background-color: #dc2626;
        }
        
        .btn-edit i, .btn-delete i {
            margin-right: 5px;
            font-size: 0.85rem;
        }

        /* État vide */
        .empty-state {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px var(--shadow-color);
            padding: 40px 20px;
            text-align: center;
            margin-top: 20px;
        }
        
        .empty-icon-container {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 5px 15px var(--shadow-color);
        }
        
        .empty-icon {
            font-size: 2rem;
            color: white;
        }
        
        .empty-text {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }
        
        .empty-description {
            color: #6b7280;
            font-size: 0.95rem;
        }
    </style>
@endsection