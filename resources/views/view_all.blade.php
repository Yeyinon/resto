@extends('master')
@section('title', 'Resto - Découvrez les restaurants')

@section('styles')
<style>
    /* Styles spécifiques pour la page de liste des restaurants */
    .hero_single.restaurant-list {
        background: url('../assets-home/img/hero_restaurant.jpg') center center no-repeat;
        background-size: cover;
        height: 450px;
        position: relative;
    }
    
    .restaurant-card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        border: none;
    }
    
    .restaurant-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(16, 185, 129, 0.2) !important;
    }
    
    .restaurant-card .card-img-top {
        height: 180px;
        object-fit: cover;
    }
    
    .restaurant-card .card-body {
        padding: 20px;
    }
    
    .restaurant-card .card-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
        font-size: 1.2rem;
    }
    
    .restaurant-card .card-location {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        color: #6B7280;
        font-size: 0.9rem;
    }
    
    .restaurant-card .card-location i {
        margin-right: 6px;
        color: var(--primary-color);
        font-size: 1rem;
    }
    
    .restaurant-card .card-footer {
        padding: 15px 20px;
        background-color: #f9fafb;
        border-top: 1px solid #f0f0f0;
    }
    
    .badge-yums {
        background-color: #fffbeb;
        color: #f59e0b;
        border: 1px solid #fef3c7;
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
    }
    
    .badge-yums.zero-yums {
        background-color: #f3f4f6;
        color: #6B7280;
        border: 1px solid #e5e7eb;
    }
    
    .badge-yums i {
        margin-right: 4px;
        font-size: 0.8rem;
    }
    
    .restaurant-search-bar {
        background-color: white;
        border-radius: 12px;
        padding: 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .restaurant-search-bar .form-control {
        border-radius: 8px;
        padding: 12px 15px 12px 45px;
        height: auto;
        border: 1px solid #e5e7eb;
        font-size: 1rem;
    }
    
    .restaurant-search-bar .form-group {
        position: relative;
        margin-bottom: 0;
    }
    
    .restaurant-search-bar i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2rem;
        color: var(--primary-color);
    }
    
    .search-btn {
        border-radius: 8px;
        padding: 13px;
        height: 100%;
        background: var(--primary-color);
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }
    
    .search-btn:hover {
        background: var(--primary-hover);
    }
    
    .filters-section {
        background-color: white;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 30px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
    }
    
    .switch-field {
        display: flex;
        overflow: hidden;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }
    
    .switch-field input {
        position: absolute !important;
        clip: rect(0, 0, 0, 0);
        height: 1px;
        width: 1px;
        border: 0;
        overflow: hidden;
    }
    
    .switch-field label {
        background-color: #f9fafb;
        color: #4b5563;
        line-height: 1;
        text-align: center;
        padding: 10px 20px;
        margin-right: -1px;
        border-right: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        flex: 1;
        font-weight: 500;
        cursor: pointer;
    }
    
    .switch-field label:hover {
        background-color: #f3f4f6;
    }
    
    .switch-field input:checked + label {
        background-color: var(--primary-color);
        color: white;
        box-shadow: none;
    }
    
    .switch-field label:first-of-type {
        border-radius: 7px 0 0 7px;
    }
    
    .switch-field label:last-of-type {
        border-radius: 0 7px 7px 0;
        border-right: none;
    }
    
    .page-header {
        margin-bottom: 30px;
    }
    
    .page-header h1 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0;
    }
    
    .breadcrumbs {
        margin-bottom: 10px;
    }
    
    .breadcrumbs ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .breadcrumbs li {
        display: flex;
        align-items: center;
        font-size: 0.9rem;
        color: #6B7280;
    }
    
    .breadcrumbs li:not(:last-child)::after {
        content: "/";
        margin: 0 8px;
        color: #9CA3AF;
    }
    
    .breadcrumbs a {
        color: #6B7280;
        transition: color 0.2s ease;
    }
    
    .breadcrumbs a:hover {
        color: var(--primary-color);
        text-decoration: none;
    }
    
    .btn-reserve {
        background-color: white;
        color: var(--primary-color);
        border: 2px solid var(--primary-color);
        border-radius: 8px;
        padding: 10px 15px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-reserve:hover {
        background-color: var(--primary-color);
        color: white;
    }
    
    .restaurant-count {
        display: inline-flex;
        align-items: center;
        background: var(--primary-light);
        color: var(--primary-dark);
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-left: 10px;
    }
    
    .restaurant-count i {
        margin-right: 5px;
        font-size: 0.8rem;
    }
    
    @media (max-width: 991px) {
        .restaurant-search-bar .form-control {
            margin-bottom: 10px;
        }
        
        .search-btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('guest')
    <main class="main-content">
        <!-- Hero Section -->
        <div class="hero_single restaurant-list">
            <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-8 col-lg-10 col-md-10 text-center">
                            <h1 class="mb-3">Découvrez nos restaurants</h1>
                            <p class="lead mb-5">Nous avons sélectionné pour vous les meilleurs restaurants au meilleur prix</p>
                            
                            <!-- Search Bar -->
                            <form method="GET" action="{{ route('search') }}" class="restaurant-search-bar">
                                <div class="row g-2">
                                    <div class="col-lg-5 col-md-5">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="query" placeholder="Cuisine, nom de restaurant...">
                                            <i class="fas fa-search"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="location" placeholder="Que recherchez-vous ?">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2">
                                        <button type="submit" class="search-btn w-100">
                                            <i class="fas fa-search d-md-none"></i>
                                            <span class="d-none d-md-block">RECHERCHER</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Page Header -->
        <div class="container mt-5">
            <div class="page-header">
                <div class="row align-items-end">
                    <div class="col-lg-8">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="/">Accueil</a></li>
                                <li><a href="{{ route('view_all') }}">Restaurants</a></li>
                            </ul>
                        </div>
                        <h1>
                            Tous les restaurants
                            <span class="restaurant-count">
                                <i class="fas fa-utensils"></i>{{ $nbr_resto }} disponibles
                            </span>
                        </h1>
                    </div>
                </div>
            </div>
            
            <!-- Filters -->
            <div class="filters-section">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h5 class="mb-0">Filtrer par:</h5>
                    </div>
                    <div class="col-md-8">
                        <div class="switch-field">
                            <input type="radio" id="all" name="listing_filter" value="all" checked data-filter="*" class="selected">
                            <label for="all">Tous</label>
                            <input type="radio" id="popular" name="listing_filter" value="popular" data-filter=".popular">
                            <label for="popular">Populaires</label>
                            <input type="radio" id="latest" name="listing_filter" value="latest" data-filter=".latest">
                            <label for="latest">Nouveautés</label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Restaurant List -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5 isotope-wrapper">
                @foreach ($restaurants as $restaurant)
                    <div class="col isotope-item">
                        <div class="restaurant-card shadow-sm">
                            @if($restaurant->image_path)
                                <a href="{{ url('client/book/' . $restaurant->id) }}"><img src="{{ asset($restaurant->image_path) }}" class="card-img-top" alt="{{ $restaurant->name }}"></a>
                            @else
                            <a href="{{ url('client/book/' . $restaurant->id) }}"><img src="{{ asset('assets-home/img/detail_3.jpg') }}" class="card-img-top" alt="{{ $restaurant->name }}"></a>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $restaurant->name }}</h5>
                                <div class="card-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $restaurant->location }}</span>
                                </div>
                                <div class="badge-yums {{ $restaurant->yums > 0 ? '' : 'zero-yums' }}">
                                    <i class="{{ $restaurant->yums > 0 ? 'fas fa-star' : 'far fa-star' }}"></i>
                                    <span>{{ $restaurant->yums > 0 ? '+'.$restaurant->yums : '0' }} Yums</span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ url('client/book/' . $restaurant->id) }}" class="btn btn-reserve w-100">
                                    <i class="fas fa-calendar-check me-2"></i>Réserver maintenant
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection

@section('scripts')
<script>
    $(window).on("load", function () {
        var $container = $('.isotope-wrapper');
        $container.isotope({
            itemSelector: '.isotope-item',
            layoutMode: 'masonry'
        });
    });
    
    $('.switch-field').on('click', 'input', function () {
        var selector = $(this).attr('data-filter');
        $('.isotope-wrapper').isotope({
            filter: selector
        });
    });
</script>
@endsection