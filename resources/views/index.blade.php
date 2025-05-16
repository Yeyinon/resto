@extends('master')

@section('title', 'Resto - Découvrez & Réservez')

@section('styles')
<style>
    /* Variables pour assurer la cohérence avec le style principal */
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

    /* Hero Section - Style épuré et cohérent avec le template principal */
    .hero_single.version_2 {
        position: relative;
        height: 500px;
        background: url('assets-home/img/home-hero.jpg') center center no-repeat;
        background-size: cover;
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .opacity-mask {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        display: flex;
        align-items: center;
        background: linear-gradient(135deg, rgba(6, 95, 70, 0.7) 0%, rgba(16, 185, 129, 0.6) 100%);
    }

    .hero_single h1 {
        color: #fff;
        font-size: 2.8rem;
        font-weight: 700;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        margin-bottom: 15px;
    }

    .hero_single p {
        color: #fff;
        font-size: 1.2rem;
        font-weight: 400;
        text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        margin-bottom: 30px;
    }

    /* Barre de recherche adaptée au style principal */
    .custom-search-input {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 8px 20px var(--shadow-color);
        overflow: hidden;
        margin: 0 auto;
        max-width: 900px;
        position: relative;
        z-index: 99;
    }

    .custom-search-input .form-group {
        margin: 0;
        position: relative;
        height: 60px;
    }

    .custom-search-input .form-control {
        border: 0;
        height: 60px;
        padding-left: 50px;
        font-size: 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .custom-search-input .form-control:focus {
        box-shadow: none;
        border-color: var(--primary-color);
    }

    .custom-search-input i {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .custom-search-input input[type="submit"] {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        border: 0;
        height: 60px;
        width: 100%;
        border-radius: 0;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .custom-search-input input[type="submit"]:hover {
        background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
    }

    /* Section des restaurants populaires */  
    .main_title {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 30px;
        padding: 0 15px;
    }

    .main_title span {
        position: relative;
        display: inline-block;
    }

    .main_title span em {
        background-color: var(--primary-color);
        width: 40px;
        height: 3px;
        border-radius: 2px;
        display: block;
        margin-bottom: 8px;
    }

    .main_title h2 {
        font-size: 1.8rem;
        font-weight: 600;
        color: var(--text-dark);
        margin: 0;
    }

    .main_title a {
        color: var(--primary-color);
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .main_title a:hover {
        color: var(--primary-dark);
    }

    /* Cartes de restaurant - Style simplifié */
    .strip {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px var(--shadow-color);
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .strip:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px var(--shadow-color);
    }

    .strip figure {
        position: relative;
        margin: 0;
    }

    .strip figure img {
        height: 200px;
        width: 100%;
        object-fit: cover;
        transition: all 0.8s ease;
    }

    .strip .ribbon {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--primary-color);
        color: white;
        padding: 6px 10px;
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: 20px;
        z-index: 1;
    }

    .strip .strip_info {
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        padding: 15px;
        color: #fff;
        background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, transparent 100%);
        text-decoration: none;
    }

    .strip .strip_info small {
        font-size: 0.9rem;
        color: rgba(255,255,255,0.8);
    }

    .strip .strip_info .item_title h3 {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 5px;
        color: white;
    }

    .strip ul {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        margin: 0;
        list-style: none;
    }

    .strip ul li a.loc_open {
        background-color: var(--primary-color);
        color: white;
        padding: 8px 15px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }

    .strip ul li a.loc_open:hover {
        background-color: var(--primary-dark);
    }

    /* Bannière - Style épuré */
    .banner {
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        margin: 40px 0;
        height: 300px;
        box-shadow: 0 8px 20px var(--shadow-color);
    }

    .banner .wrapper {
        width: 100%;
        height: 100%;
        padding: 30px;
    }

    .banner small {
        font-size: 1rem;
        color: white;
        font-weight: 500;
        margin-bottom: 10px;
        display: block;
    }

    .banner h3 {
        font-size: 2.2rem;
        color: white;
        font-weight: 700;
        margin-bottom: 15px;
        text-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }

    .banner p {
        font-size: 1.1rem;
        color: white;
        max-width: 400px;
        font-weight: 400;
        text-shadow: 0 2px 5px rgba(0,0,0,0.3);
    }

    /* Section d'appel à l'action - Stylisation cohérente */
    .call_section {
        position: relative;
        padding: 60px 0;
        background-color: var(--background-light);
        overflow: hidden;
    }

    .box_1 {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 20px var(--shadow-color);
        position: relative;
        z-index: 2;
    }

    .box_1 h3 {
        font-size: 1.6rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 15px;
    }

    .box_1 p {
        font-size: 1rem;
        margin-bottom: 25px;
        color: #666;
        line-height: 1.5;
    }

    .btn_1 {
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 6px;
        padding: 12px 25px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
    }

    .btn_1:hover {
        background-color: var(--primary-dark);
        color: white;
    }

    /* Carrousel - Adaptation du style */
    .owl-carousel .owl-nav button.owl-next, 
    .owl-carousel .owl-nav button.owl-prev {
        background-color: white;
        color: var(--primary-dark);
        width: 36px;
        height: 36px;
        border-radius: 50%;
        box-shadow: 0 3px 10px var(--shadow-color);
        transition: all 0.3s ease;
    }

    .owl-carousel .owl-nav button.owl-next:hover, 
    .owl-carousel .owl-nav button.owl-prev:hover {
        background-color: var(--primary-color);
        color: white;
    }

    /* Élément autotyping */
    .element {
        display: inline-block;
        position: relative;
        color: var(--primary-light);
        font-weight: 600;
    }

    .element:after {
        content: '';
        position: absolute;
        right: -5px;
        top: 50%;
        transform: translateY(-50%);
        height: 60%;
        width: 2px;
        background-color: white;
        animation: blink 0.7s infinite;
    }

    @keyframes blink {
        0%, 100% { opacity: 1; }
        50% { opacity: 0; }
    }
    
    /* Optimisations pour mobile */
    @media (max-width: 991px) {
        .hero_single.version_2 {
            height: 400px;
        }
        
        .hero_single h1 {
            font-size: 2.2rem;
        }
        
        .custom-search-input {
            border-radius: 8px;
        }
        
        .banner {
            height: 280px;
        }
        
        .banner h3 {
            font-size: 1.8rem;
        }
    }
    
    @media (max-width: 767px) {
        .hero_single.version_2 {
            height: 350px;
        }
        
        .hero_single h1 {
            font-size: 1.8rem;
        }
        
        .hero_single p {
            font-size: 1rem;
        }
        
        .custom-search-input .form-group,
        .custom-search-input .form-control,
        .custom-search-input input[type="submit"] {
            height: 50px;
        }
        
        .strip .strip_info .item_title h3 {
            font-size: 1.1rem;
        }
    }
</style>
@endsection

@section('guest')
    <!-- Hero Section -->
    <div class="hero_single version_2">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10 col-md-8 text-center">
                        <h1>Découvrez &amp; Réservez</h1>
                        <p>le meilleur restaurant <span class="element" style="font-weight: 500">à proximité</span></p>
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
    </div>
    
    <!-- Search Bar -->
    <div class="container">
        <form method="GET" action="{{ route('client_login_form') }}">
            @csrf
            <div class="row g-0 custom-search-input">
                <div class="col-lg-4">
                    <div class="form-group">
                        <input class="form-control" type="text" name="query" placeholder="Que recherchez vous ?...">
                        <i class="icon_search"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input class="form-control no_border_r" type="text" name="location"
                            placeholder="Cuisine, nom de restaurant...">
                        <i class="icon_pin_alt"></i>
                    </div>
                </div>
                <div class="col-lg-2">
                    <input type="submit" value="RECHERCHE">
                </div>
            </div>
        </form>
    </div>
    
    <!-- Popular Restaurants Section -->
    <div class="container margin_60_40">
        <div class="main_title">
            <div>
                <span><em></em></span>
                <h2>Restaurants populaires</h2>
            </div>
            <a href="{{ route('view_all') }}">Voir tout <i class="fas fa-arrow-right ml-2"></i></a>
        </div>

        <div class="owl-carousel owl-theme carousel_4">
            @foreach ($restaurants as $restaurant)
                <div class="item">
                    <div class="strip">
                        <figure>
                            @if($restaurant->yums > 0)
                                <span class="ribbon">+ {{ $restaurant->yums }} Yums</span>
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
                        <ul>
                            <li><a class="loc_open" href="client/book/{{ $restaurant->id }}">Réservez ici</a></li>
                            <li></li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
        <!-- /carousel -->

        <!-- Banner Section -->
        <div class="banner lazy" data-bg="url(assets-home/img/blog-1.jpg)">
            <div class="wrapper d-flex align-items-center opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div>
                    <small>Resto</small>
                    <h3>Plus de 100 restaurants</h3>
                    <p>Réservez une table facilement au meilleur prix</p>
                </div>
            </div>
            <!-- /wrapper -->
        </div>
        <!-- /banner -->
    </div>

    <!-- Call to Action Section -->
    <div class="call_section lazy" data-bg="url(img/reservation-bg.jpg)">
        <div class="container clearfix">
            <div class="col-lg-5 col-md-6 float-end">
                <div class="box_1">
                    <h3>Êtes-vous un propriétaire de restaurant?</h3>
                    <p>Rejoignez-nous pour augmenter votre visibilité en ligne. Vous aurez accès à encore plus de
                        clients qui souhaitent profiter de vos plats savoureux à la maison.</p>
                    <a href="{{ route('restaurant.register') }}" class="btn_1">En savoir plus</a>
                </div>
            </div>
        </div>
    </div>
    <!--/call_section-->
@endsection

@section('scripts')
<script>
    // Script pour animer l'élément avec le texte défilant
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Typed !== 'undefined') {
            var typed = new Typed('.element', {
                strings: ["à proximité", "au meilleur prix", "selon vos envies", "avec Resto"],
                typeSpeed: 70,
                backSpeed: 40,
                backDelay: 2000,
                loop: true
            });
        }
    });
</script>
@endsection