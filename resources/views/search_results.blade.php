@extends('master')

@section('title', 'Resto - Découvrez & Réservez')

@section('styles')
<style>
    /* Styles spécifiques pour cette vue */
    .strip {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 8px 20px var(--shadow-color);
        margin-bottom: 30px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .strip:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px var(--shadow-color);
    }
    
    .strip figure {
        position: relative;
        margin: 0;
        overflow: hidden;
        height: 220px;
    }
    
    .strip figure img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .strip:hover figure img {
        transform: scale(1.05);
    }
    
    .strip .strip_info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0) 100%);
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .strip .strip_info small {
        display: block;
        color: var(--primary-light);
        font-size: 0.8rem;
        margin-bottom: 5px;
    }
    
    .strip .item_title h3 {
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0 0 5px 0;
        color: white;
    }
    
    .ribbon {
        position: absolute;
        top: 10px;
        right: 10px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 5px 10px;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 20px;
        z-index: 1;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    
    /* Style pour la section de contenu principal */
    main {
        padding: 50px 0;
        background-color: var(--background-light);
    }
    
    /* Titre de section */
    .section-title {
        text-align: center;
        margin-bottom: 40px;
        position: relative;
    }
    
    .section-title h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
    }
    
    .section-title p {
        color: #666;
        font-size: 1.1rem;
        max-width: 700px;
        margin: 10px auto 0;
    }
    
    /* Pour les filtres en haut de la liste des restaurants */
    .filters-container {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px var(--shadow-color);
    }
    
    .filter-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-right: 15px;
    }
    
    .filter-btn {
        background-color: white;
        border: 1px solid #e0e0e0;
        border-radius: 20px;
        padding: 5px 15px;
        margin-right: 10px;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    
    .filter-btn:hover, .filter-btn.active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    /* Pagination */
    .pagination-container {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    
    .page-link {
        color: var(--primary-color);
        border: 1px solid var(--border-color);
        margin: 0 5px;
        border-radius: 5px;
        transition: all 0.2s ease;
    }
    
    .page-link:hover, .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
        color: white;
    }
</style>
@endsection

@section('guest')
<!-- Hero section avec titre et description -->
<div class="page-title-section">
    <div class="container">
        <h1 class="page-title">Découvrez les meilleurs restaurants</h1>
        <div class="breadcrumb-modern">
            <a href="/" class="breadcrumb-item">Accueil</a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <span class="breadcrumb-item active">Restaurants</span>
        </div>
    </div>
</div>

<!-- Contenu principal -->
<div class="main-content">
    <div class="container">
        <!-- Filtres optionnels -->
        <div class="filters-container d-flex align-items-center flex-wrap">
            <span class="filter-title">Filtrer par:</span>
            <button class="filter-btn active">Tous</button>
            <button class="filter-btn">Français</button>
            <button class="filter-btn">Italien</button>
            <button class="filter-btn">Asiatique</button>
            <button class="filter-btn">Avec Yums</button>
        </div>
        
        <!-- Liste des restaurants -->
        <div class="row">
            @foreach ($restaurants as $restaurant)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="strip">
                        <figure>
                            @if($restaurant->yums > 0)
                                <span class="ribbon">+ {{ $restaurant->yums }} Yums</span>
                            @endif

                            @if($restaurant->image_path)
                                <!-- Utiliser l'image téléchargée par le restaurant si disponible -->
                                <img src="{{ asset($restaurant->image_path) }}" data-src="{{ asset($restaurant->image_path) }}"
                                    class="img-fluid" alt="{{ $restaurant->name }}">
                            @else
                                <!-- Utiliser l'image par défaut si aucune image n'a été téléchargée -->
                                <img src="{{ asset('assets-home/img/detail_3.jpg') }}"
                                    data-src="{{ asset('assets-home/img/home_section_1.jpg') }}" class="img-fluid"
                                    alt="{{ $restaurant->name }}">
                            @endif

                            <a href="{{ url('client/book/' . $restaurant->id) }}" class="strip_info">
                                <small>{{ $restaurant->location }}</small>
                                <div class="item_title">
                                    <h3>{{ $restaurant->name }}</h3>
                                    <small><i class="fas fa-map-marker-alt"></i> {{ $restaurant->location }}</small>
                                </div>
                            </a>
                        </figure>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="pagination-container">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Script pour activer les filtres
    document.addEventListener('DOMContentLoaded', function() {
        // Sélectionner tous les boutons de filtre
        const filterButtons = document.querySelectorAll('.filter-btn');
        
        // Ajouter un écouteur d'événement à chaque bouton
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Retirer la classe active de tous les boutons
                filterButtons.forEach(btn => btn.classList.remove('active'));
                
                // Ajouter la classe active au bouton cliqué
                this.classList.add('active');
                
                // Logique de filtrage (à implémenter avec AJAX ou JS)
                const filterValue = this.textContent;
                console.log('Filtrage par:', filterValue);
                
                // Ici vous pouvez ajouter la logique pour filtrer les restaurants
                // ou faire une requête AJAX pour récupérer les données filtrées
            });
        });
    });
</script>
@endsection