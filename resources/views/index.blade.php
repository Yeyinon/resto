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

    /* Section des restaurants populaires et autres sections */
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
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        margin-top: 0;
    }
    .owl-carousel .owl-nav button.owl-prev {
        left: -15px;
    }
    .owl-carousel .owl-nav button.owl-next {
        right: -15px;
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

    /* Styles des nouvelles sections */
    .how_it_works {
        background-color: var(--background-light);
        padding: 60px 0;
    }
    .how_it_works .box_topic {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--shadow-color);
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .how_it_works .box_topic:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px var(--shadow-color);
    }
    .how_it_works .box_topic i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    .how_it_works .box_topic h4 {
        font-size: 1.3rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
    }
    .how_it_works .box_topic p {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
    }

    /* Section "Pourquoi choisir Resto" */
    .why_choose_us {
        padding: 60px 0;
    }
    .why_choose_us .feature_item {
        background-color: #fff;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--shadow-color);
        text-align: center;
        margin-bottom: 25px;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .why_choose_us .feature_item i {
        font-size: 2.8rem;
        color: var(--primary-color);
        margin-bottom: 15px;
    }
    .why_choose_us .feature_item h4 {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 10px;
    }
    .why_choose_us .feature_item p {
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
    }

    /* Section "Témoignages de nos clients" */
    .testimonials_section {
        background-color: var(--background-light);
        padding: 60px 0;
    }
    .testimonial_item {
        background-color: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 15px var(--shadow-color);
        text-align: center;
        margin-bottom: 20px;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .testimonial_item .rating {
        color: #ffc107; /* Couleur des étoiles */
        margin-bottom: 15px;
        font-size: 1.2rem;
    }
    .testimonial_item p {
        font-style: italic;
        color: #555;
        line-height: 1.6;
        margin-bottom: 20px;
    }
    .testimonial_item .author {
        font-weight: 600;
        color: var(--text-dark);
    }
    .testimonial_item .author small {
        display: block;
        font-weight: 400;
        color: #888;
        margin-top: 5px;
    }

    /* Section FAQ */
    .faq_section {
        padding: 60px 0;
    }
    .faq_section .accordion-button {
        background-color: var(--primary-light);
        color: var(--text-dark);
        font-weight: 600;
        border-radius: 8px;
        padding: 15px 20px;
        transition: background-color 0.3s ease;
    }
    .faq_section .accordion-button:not(.collapsed) {
        background-color: var(--primary-color);
        color: white;
        box-shadow: none;
    }
    .faq_section .accordion-button:focus {
        box-shadow: none;
        border-color: var(--primary-color);
    }
    .faq_section .accordion-body {
        background-color: #fff;
        border-radius: 0 0 8px 8px;
        padding: 20px;
        border: 1px solid var(--border-color);
        border-top: none;
        color: #555;
    }
    .faq_section .accordion-item {
        margin-bottom: 10px;
        border: none;
        box-shadow: 0 2px 10px rgba(16, 185, 129, 0.08);
        border-radius: 8px;
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

        .owl-carousel .owl-nav button.owl-prev {
            left: 5px;
        }
        .owl-carousel .owl-nav button.owl-next {
            right: 5px;
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
    @media (max-width: 575px) {
        .main_title {
            flex-direction: column;
            text-align: center;
        }
        .main_title a {
            margin-top: 15px;
        }
        .custom-search-input .col-lg-4,
        .custom-search-input .col-lg-6,
        .custom-search-input .col-lg-2 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        .custom-search-input input[type="submit"] {
            border-radius: 0 0 12px 12px; /* Ajuster le border-radius pour les boutons empilés */
        }
        .custom-search-input .form-group:last-child .form-control {
            border-bottom: 0;
        }
    }
</style>
@endsection

@section('guest')
    <div class="hero_single version_2">
        <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-9 col-lg-10 col-md-8 text-center">
                        <h1>Découvrez &amp; Réservez</h1>
                        <p>le meilleur restaurant <span class="element" style="font-weight: 500">à proximité</span></p>
                    </div>
                </div>
                </div>
        </div>
    </div>
    
    <div class="container">
        <form method="GET" action="{{ route('client_login_form') }}">
            @csrf
            <div class="row g-0 custom-search-input">
                <div class="col-lg-4">
                    <div class="form-group">
                        <input class="form-control" type="text" name="query" placeholder="Cuisine, nom de restaurant...">
                        <i class="icon_search"></i>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group">
                        <input class="form-control no_border_r" type="text" name="location"
                            placeholder="Où cherchez-vous ?...">
                        <i class="icon_pin_alt"></i>
                    </div>
                </div>
                <div class="col-lg-2">
                    <input type="submit" value="RECHERCHE">
                </div>
            </div>
        </form>
    </div>
    
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
                                <img src="{{ asset($restaurant->image_path) }}" data-src="{{ asset($restaurant->image_path) }}"
                                    class="owl-lazy" alt="{{ $restaurant->name }}">
                            @else
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
        </div>

    <div class="container margin_60_40 how_it_works">
        <div class="main_title text-center">
            <div>
                <span><em></em></span>
                <h2>Comment ça marche</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="box_topic">
                    <i class="icon_search_alt"></i>
                    <h4>1. Trouvez votre restaurant</h4>
                    <p>Utilisez notre barre de recherche intuitive pour trouver des restaurants par cuisine, localisation ou nom.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="box_topic">
                    <i class="icon_pencil-edit"></i>
                    <h4>2. Réservez facilement</h4>
                    <p>Sélectionnez la date, l'heure et le nombre de personnes. Confirmez votre réservation en quelques clics.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="box_topic">
                    <i class="icon_table"></i>
                    <h4>3. Profitez de votre repas</h4>
                    <p>Rendez-vous au restaurant à l'heure réservée et savourez une expérience culinaire sans tracas.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container margin_60_40 why_choose_us">
        <div class="main_title text-center">
            <div>
                <span><em></em></span>
                <h2>Pourquoi choisir Resto ?</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="icon_check_alt2"></i>
                    <h4>Simplicité et Rapidité</h4>
                    <p>Réservez une table en quelques secondes, sans appel téléphonique ni attente.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="icon_wallet"></i>
                    <h4>Meilleurs prix & Offres exclusives</h4>
                    <p>Profitez de réductions et d'avantages exclusifs sur vos réservations.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="icon_star-empty_alt"></i>
                    <h4>Avis clients vérifiés</h4>
                    <p>Fiez-vous aux retours authentiques de notre communauté pour faire votre choix.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="icon_pin_alt"></i>
                    <h4>Large choix de restaurants</h4>
                    <p>Découvrez une multitude de restaurants près de chez vous ou pour vos voyages.</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="feature_item">
                    <i class="icon_like"></i>
                    <h4>Service Clientèle Dévoué</h4>
                    <p>Notre équipe est là pour vous accompagner à chaque étape de votre réservation.</p>
                </div>
            </div>
        </div>
    </div>         

<div class="container margin_60_40 testimonials_section">
    <div class="main_title text-center">
        <div>
            <span><em></em></span>
            <h2>Ils nous font confiance</h2>
        </div>
    </div>
    <div class="owl-carousel owl-theme carousel_1">
        {{-- Ici, vous chargerez les avis de vos clients depuis la base de données.
             Ces avis doivent être liés à des réservations ou à l'utilisation de la plateforme. --}}
        {{-- Exemple statique (à remplacer par des données dynamiques) --}}

        {{-- DEBUTER LE CODE ICI --}}
        @if ($comments->isEmpty())
            <p>Aucun commentaire n'a encore été publié.</p>
        @else
            @foreach ($comments as $comment)
                <div class="item">
                    <div class="testimonial_item">
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $comment->rating)
                                    <i class="icon_star voted"></i>
                                @else
                                    <i class="icon_star empty"></i>
                                @endif
                            @endfor
                        </div>
                        <p>"{{ $comment->content }}"</p>
                        <div class="author">
                            {{ $comment->client->name ?? 'Client Anonyme' }} {{-- Utilise la relation client --}}
                            <small>
                                @if ($comment->restaurant)
                                    (Réservation chez '{{ $comment->restaurant->name }}') {{-- Utilise la relation restaurant --}}
                                @else
                                    (Utilisateur de la plateforme) {{-- Pour les commentaires qui ne seraient pas liés à un restaurant spécifique --}}
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        {{-- FINIR LE CODE ICI --}}

    </div>
</div>

    <div class="container margin_60_40 faq_section">
        <div class="main_title text-center">
            <div>
                <span><em></em></span>
                <h2>Questions Fréquentes</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                Comment puis-je réserver un restaurant sur Resto ?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Utilisez la barre de recherche en haut de la page pour trouver un restaurant par nom, localisation ou type de cuisine. Une fois sur la page du restaurant, choisissez la date, l'heure et le nombre de convives, puis cliquez sur "Réserver". Suivez les étapes de confirmation.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Les réservations sont-elles gratuites ?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Oui, la réservation via Resto est entièrement gratuite pour les utilisateurs. Il n'y a aucun frais caché.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Comment modifier ou annuler une réservation ?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Après avoir effectué une réservation, vous recevrez un email de confirmation. Cet email contiendra un lien pour modifier ou annuler votre réservation si nécessaire. Vous pouvez également le faire depuis votre espace client.
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Comment laisser un avis sur un restaurant ?
                            </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Une fois votre repas terminé et après la date de votre réservation, vous recevrez une invitation par email pour laisser un avis sur le restaurant. Vos avis aident les autres utilisateurs à faire leur choix !
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="banner lazy" data-bg="url(assets-home/img/blog-1.jpg)">
            <div class="wrapper d-flex align-items-center opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                <div>
                    <small>Resto</small>
                    <h3>Plus de 100 restaurants</h3>
                    <p>Réservez une table facilement au meilleur prix</p>
                </div>
            </div>
            </div>
        </div>

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

        // Initialiser Owl Carousel pour la section "Témoignages de nos clients"
        if (typeof jQuery !== 'undefined' && jQuery().owlCarousel) {
            jQuery('.carousel_1').owlCarousel({
                center: false,
                items: 1,
                loop: true,
                margin: 20,
                nav: true,
                dots: false,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    992: {
                        items: 3
                    }
                }
            });
        }
    });
</script>
@endsection