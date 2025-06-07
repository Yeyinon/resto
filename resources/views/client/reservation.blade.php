@extends('master')
@section('guest')
    <title>Resto - Reservation</title>

    <div class="page-title-section">
        <div class="container">
            </div>
    </div>

    <main class="main-content">
        <div class="container margin_detail">
            <div class="row">
                <div class="col-lg-8">
                    <div class="content-card">
                        <div class="restaurant-info">
                            <h2>{{ $restaurant->name }}</h2>
                            <div class="restaurant-meta">
                                <span><i class="fas fa-map-marker-alt"></i> {{ $restaurant->location }}</span>
                                <span><i class="fas fa-table"></i> {{ $tableCount }} tables</span>
                                <span><i class="fas fa-gift"></i> +{{ $restaurant->yums }} yums</span>
                                @if($comments->count() > 0)
                                    @php
                                        $averageRating = $comments->avg('rating');
                                        $totalComments = $comments->count();
                                    @endphp
                                    <span><i class="fas fa-star"></i> {{ number_format($averageRating, 1) }}/5 ({{ $totalComments }} avis)</span>
                                @endif
                            </div>
                            <div class="restaurant-description">
                                <p>{{ $restaurant->description }}</p>
                            </div>
                            <div class="restaurant-actions">
                                <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($restaurant->location) }}" target="_blank" class="btn-primary-custom">
                                    <i class="fas fa-directions"></i> Itinéraire
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Section pour afficher les menus et les plats --}}
                    <div class="content-card mt-4">
                        <h3>Notre Menu</h3>
                        @if($menus->count() > 0)
                            @foreach($menus as $menu)
                                <div class="menu-category mb-4">
                                    <h4>{{ $menu->nom }}</h4>
                                    @if($menu->plats->count() > 0)
                                        <div class="row">
                                            @foreach($menu->plats as $plat)
                                                <div class="col-md-4 col-sm-6 mb-3">
                                                    <div class="menu-item text-center">
                                                        @if($plat->photo)
                                                            <img src="{{ asset('storage/' . $plat->photo) }}" alt="{{ $plat->nom }}" class="img-fluid rounded menu-item-photo">
                                                        @else
                                                            <img src="{{ asset('images/placeholder-plat.png') }}" alt="Image non disponible" class="img-fluid rounded menu-item-photo">
                                                        @endif
                                                        <p class="menu-item-name mt-2"><strong>{{ $plat->nom }}</strong></p>
                                                        {{-- Ne pas afficher le prix ici --}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>Aucun plat disponible pour ce menu.</p>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p>Aucun menu disponible pour ce restaurant.</p>
                        @endif
                    </div>

                    <div class="content-card">
                        <div class="comment-section">
                            <h3><i class="fas fa-comments"></i> Avis et commentaires</h3>

                            @auth('client')
                                <div class="comment-form" id="comment-form-container">
                                    </div>
                            @else
                                <div class="comment-form">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <a href="{{ route('client.login') }}">Connectez-vous</a> pour laisser un avis après avoir honoré une réservation.
                                    </div>
                                </div>
                            @endauth

                            <div class="comments-list">
                                <h4>{{ count($comments) }} Avis</h4>

                                @foreach ($comments as $comment)
                                <div class="comment-item">
                                    <div class="row">
                                        <div class="col-md-2 user-info">
                                            <img src="{{ asset('img/client_user.png') }}" alt="{{ $comment->client->name }}" class="user-avatar">
                                            <h5>{{ $comment->client->name }}</h5>
                                        </div>
                                        <div class="col-md-10 comment-content">
                                            <div class="comment-meta">
                                                <div class="rating-stars">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $comment->rating ? 'star-filled' : 'star-empty' }}"></i>
                                                    @endfor
                                                    <span class="rating-text">{{ $comment->rating }}/5</span>
                                                </div>
                                                <span class="comment-date">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <p>{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                @if($comments->count() == 0)
                                    <div class="no-comments">
                                        <p><i class="fas fa-comment-slash"></i> Aucun avis pour le moment. Soyez le premier à partager votre expérience !</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4" id="sidebar_fixed">
                    <div class="content-card reservation-card">
                        <div class="reservation-header">
                            <h3><i class="fas fa-calendar-check"></i> Réservez votre table</h3>
                            <div class="yums-offer">
                                <i class="fas fa-gift"></i> +{{ $restaurant->yums }} yums offerts
                            </div>
                        </div>

                        <div class="reservation-form">
                            <form method="post" action="{{ route('client.reservation.create') }}" id="reservationForm">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @csrf
                                <input type="hidden" name="client_id" value="{{ Auth::guard('client')->id() }}">
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                                <div class="form-group">
                                    <label><i class="fas fa-calendar-alt"></i> Date</label>
                                    <input required class="form-control date-input" type="date" name="reservation_date"
                                        min="{{ date('Y-m-d') }}" id="reservation_date">
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-clock"></i> Heure</label>
                                    <div class="time-slots">
                                        {{-- NOUVELLE CATÉGORIE : PETIT DÉJEUNER --}}
                                        <div class="time-category">
                                            <h5>Petit Déjeuner</h5>
                                            <div class="time-options">
                                                @php
                                                    $breakfast_start = strtotime('08:00');
                                                    $breakfast_end = strtotime('11:00');
                                                    $interval = 30 * 60; // 30 minutes in seconds
                                                @endphp
                                                @for ($time = $breakfast_start; $time <= $breakfast_end; $time += $interval)
                                                    <div class="time-option">
                                                        <input type="radio" id="time_pb_{{ date('Hi', $time) }}" name="reservation_time" value="{{ date('H:i:s', $time) }}">
                                                        <label for="time_pb_{{ date('Hi', $time) }}">{{ date('H:i', $time) }}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>

                                        {{-- CATÉGORIE DÉJEUNER MISE À JOUR --}}
                                        <div class="time-category">
                                            <h5>Déjeuner</h5>
                                            <div class="time-options">
                                                @php
                                                    $lunch_start = strtotime('12:00');
                                                    $lunch_end = strtotime('15:00');
                                                @endphp
                                                @for ($time = $lunch_start; $time <= $lunch_end; $time += $interval)
                                                    <div class="time-option">
                                                        <input type="radio" id="time_l_{{ date('Hi', $time) }}" name="reservation_time" value="{{ date('H:i:s', $time) }}">
                                                        <label for="time_l_{{ date('Hi', $time) }}">{{ date('H:i', $time) }}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>

                                        {{-- AJOUT D'UNE CATÉGORIE APRÈS-MIDI (OPTIONNEL) --}}
                                        <div class="time-category">
                                            <h5>Après-midi</h5>
                                            <div class="time-options">
                                                @php
                                                    $afternoon_start = strtotime('15:30');
                                                    $afternoon_end = strtotime('18:30');
                                                @endphp
                                                @for ($time = $afternoon_start; $time <= $afternoon_end; $time += $interval)
                                                    <div class="time-option">
                                                        <input type="radio" id="time_a_{{ date('Hi', $time) }}" name="reservation_time" value="{{ date('H:i:s', $time) }}">
                                                        <label for="time_a_{{ date('Hi', $time) }}">{{ date('H:i', $time) }}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>

                                        {{-- CATÉGORIE DÎNER MISE À JOUR --}}
                                        <div class="time-category">
                                            <h5>Dîner</h5>
                                            <div class="time-options">
                                                @php
                                                    $dinner_start = strtotime('19:00');
                                                    $dinner_end = strtotime('23:00'); // Extended to 23:00 (11 PM)
                                                @endphp
                                                @for ($time = $dinner_start; $time <= $dinner_end; $time += $interval)
                                                    <div class="time-option">
                                                        <input type="radio" id="time_d_{{ date('Hi', $time) }}" name="reservation_time" value="{{ date('H:i:s', $time) }}">
                                                        <label for="time_d_{{ date('Hi', $time) }}">{{ date('H:i', $time) }}</label>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-users"></i> Table</label>
                                    {{-- Le conteneur pour la nouvelle grille de tables --}}
                                    <div id="table-options-container">
                                        <p class="select-date-time-message">Veuillez d'abord sélectionner une date et une heure</p>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label><i class="fas fa-envelope"></i> Email</label>
                                    <input class="form-control" required type="email" name="reservation_email"
                                        @if (Auth::guard('client')->check()) value="{{ Auth::guard('client')->user()->email }}" @else placeholder="Votre email" @endif>
                                </div>

                                <div class="form-group">
                                    <label for="reservation_tele">Téléphone *</label>
                                    <input type="text" id="reservation_tele" name="reservation_tele" class="form-control" required>
                                    @error('reservation_tele')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn-primary-custom btn-block">
                                    <i class="fas fa-check-circle"></i> Réserver maintenant
                                </button>

                                <div class="reservation-info">
                                    <small><i class="fas fa-info-circle"></i> Aucun frais ne sera prélevé à cette étape</small>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="content-card yums-info-card">
                        <div class="yums-info">
                            <i class="fas fa-award"></i>
                            <p>Réservez sur Resto pour cumuler des Yums et profiter de remises fidélité exclusives</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        .restaurant-info {
            margin-bottom: 20px;
        }

        .restaurant-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 15px 0;
            color: #555;
        }

        .restaurant-meta span {
            display: flex;
            align-items: center;
        }

        .restaurant-meta i {
            margin-right: 5px;
            color: var(--primary-color);
        }

        .restaurant-description {
            margin: 15px 0;
            line-height: 1.6;
        }

        /* Menu section */
        .menu-section {
            margin-top: 10px;
        }

        .menu-items {
            margin-top: 20px;
        }

        .menu-item {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .menu-item:last-child {
            border-bottom: none;
        }

        .menu-item-details h4 {
            margin-bottom: 5px;
            color: var(--text-dark);
        }

        .menu-item-price {
            font-weight: 600;
            color: var(--primary-color);
        }

        .menu-empty {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            text-align: center;
        }

        /* Comment section */
        .comment-section {
            margin-top: 10px;
        }

        .comment-form {
            margin: 20px 0;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        /* Système de notation par étoiles */
        .rating-input {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 15px 0;
        }

        .star-rating {
            display: flex;
            flex-direction: row-reverse; /* Pour que le :hover fonctionne correctement */
            gap: 5px;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 1.8rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s ease;
        }

        .star-rating input[type="radio"]:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffd700;
        }

        .rating-stars {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 10px;
        }

        .star-filled {
            color: #ffd700;
        }

        .star-empty {
            color: #ddd;
        }

        .rating-text {
            margin-left: 10px;
            color: #777;
            font-weight: 500;
        }

        .comments-list {
            margin-top: 30px;
        }

        .comment-item {
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .user-avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info {
            text-align: center;
        }

        .comment-meta {
            margin-bottom: 10px;
            color: #777;
            font-size: 0.9rem;
        }

        .no-comments {
            text-align: center;
            padding: 40px 20px;
            color: #777;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-info {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
        }

        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }

        .reservation-card {
            position: sticky;
            top: 100px;
        }

        .reservation-header {
            margin-bottom: 20px;
            border-bottom: 2px solid var(--primary-light);
            padding-bottom: 15px;
        }

        .yums-offer {
            margin-top: 10px;
            color: var(--primary-color);
            font-weight: 500;
        }

        .yums-offer i {
            margin-right: 5px;
        }

        .time-slots {
            margin: 15px 0;
            margin-bottom: 30px;
        }

        .time-category {
            margin-bottom: 15px;
        }

        .time-category h5 {
            margin-bottom: 10px;
            color: var(--text-dark);
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            font-size: 1.1em;
        }

        .time-options {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .time-option {
            position: relative;
        }

        .time-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }

        .time-option label {
            display: block;
            padding: 8px 15px;
            background-color: #f0f0f0;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .time-option input[type="radio"]:checked + label {
            background-color: var(--primary-color);
            color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .time-option label:hover {
            background-color: #e0e0e0;
        }

        .reservation-info {
            text-align: center;
            margin-top: 15px;
            color: #777;
        }

        .yums-info-card {
            margin-top: 20px;
        }

        .yums-info {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: #f0fbf8;
            border-radius: 8px;
            border: 1px solid #c7f2e1;
        }

        .yums-info i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }

        .btn-block {
            display: block;
            width: 100%;
        }

        .menu-item-photo {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .menu-item-name {
            font-size: 1.1em;
            color: #333;
            font-weight: 600;
        }
        .menu-category h4 {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
            color: var(--primary-dark);
            font-size: 1.4em;
        }
        .content-card {
            background-color: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            margin-bottom: 20px;
        }
        h2, h3 {
            color: var(--primary-dark);
            margin-bottom: 15px;
        }
        .btn-primary-custom {
            background-color: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
            border: none;
            cursor: pointer;
            font-weight: 500;
        }
        .btn-primary-custom:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(16, 185, 129, 0.4);
        }

        /* Nouveaux styles pour la grille des tables */
        .table-options-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); /* 2 ou 3 colonnes */
            gap: 15px;
            margin-top: 15px;
            max-height: 350px;
            overflow-y: auto;
            padding: 5px;
        }

        .table-item {
            background-color: #f8f9fa;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: all 0.2s ease;
            cursor: pointer;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 120px;
        }

        .table-item input[type="radio"] {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .table-item.available:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(16, 185, 129, 0.2);
            border-color: var(--primary-color);
        }

        .table-item.selected {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light), 0 6px 15px rgba(16, 185, 129, 0.3);
            background-color: #d1fae5;
            transform: translateY(-3px);
        }

        .table-item.reserved {
            border-color: #fca5a5;
            background-color: #fef2f2;
            opacity: 0.7;
            cursor: not-allowed;
            box-shadow: none;
        }

        .table-item-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #6b7280;
        }

        .table-item.available .table-item-icon {
            color: var(--primary-dark);
        }
        .table-item.selected .table-item-icon {
            color: var(--primary-dark);
        }
        .table-item.reserved .table-item-icon {
            color: #dc2626;
        }

        .table-item-capacity {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .table-item-location {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 5px;
        }

        .table-item-status {
            font-size: 0.8rem;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 15px;
            margin-top: 8px;
        }

        .table-item.available .table-item-status {
            color: #059669;
            background-color: #d1fae5;
        }

        .table-item.reserved .table-item-status {
            color: #b91c1c;
            background-color: #fee2e2;
        }

        .select-date-time-message {
            text-align: center;
            color: #777;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: 15px;
        }

    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById('reservation_date');
        const timeInputs = document.querySelectorAll('input[name="reservation_time"]');
        const tableOptionsContainer = document.getElementById('table-options-container'); // Conteneur mis à jour
        const reservationForm = document.getElementById('reservationForm');
        const commentFormContainer = document.getElementById('comment-form-container');

        // Vérifier si le client peut commenter
        @auth('client')
        checkCommentPermission();
        @endauth

        function checkCommentPermission() {
            fetch(`/api/check-comment-permission/{{ $restaurant->id }}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.can_comment) {
                    showCommentForm();
                } else {
                    showCommentMessage(data.message);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la vérification des permissions de commentaire:', error);
            });
        }

        function showCommentForm() {
            commentFormContainer.innerHTML = `
                <form action="{{ route('comments.store') }}" method="POST" id="commentForm">
                    @csrf
                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                    <div class="form-group">
                        <label for="rating">Votre note *</label>
                        <div class="rating-input">
                            <div class="star-rating" id="star-rating">
                                <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="Excellent">★</label>
                                <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="Très bien">★</label>
                                <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="Correct">★</label>
                                <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="Décevant">★</label>
                                <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="Très décevant">★</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">Votre avis *</label>
                        <textarea name="content" id="content" required class="form-control" rows="4"
                            placeholder="Partagez votre expérience pour aider les autres utilisateurs" maxlength="1000"></textarea>
                        <small class="form-text text-muted">Maximum 1000 caractères</small>
                    </div>
                    <button type="submit" class="btn-primary-custom">
                        <i class="fas fa-paper-plane"></i> Publier mon avis
                    </button>
                </form>
            `;
            initStarRating();
        }

        function showCommentMessage(message) {
            commentFormContainer.innerHTML = `
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    ${message}
                </div>
            `;
        }

        function initStarRating() {
            // Logique pour le rating par étoiles
        }

        // --- NOUVELLE FONCTION AMÉLIORÉE POUR AFFICHER LES TABLES ---
        function updateAvailableTables() {
            const selectedDate = dateInput.value;
            const selectedTimeInput = document.querySelector('input[name="reservation_time"]:checked');

            if (!selectedDate || !selectedTimeInput) {
                tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Veuillez d\'abord sélectionner une date et une heure</p>';
                return;
            }

            const selectedTime = selectedTimeInput.value;
            tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Chargement des tables disponibles...</p>';

            fetch(`/api/available-tables?restaurant_id={{ $restaurant->id }}&date=${selectedDate}&time=${selectedTime}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                const availableTables = data.tables || [];
                const reservedTableIds = data.reservées || [];

                if (availableTables.length === 0) {
                    tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Aucune table disponible à cette date et heure.</p>';
                    return;
                }

                tableOptionsContainer.innerHTML = ''; // Vider le conteneur
                const grid = document.createElement('div');
                grid.className = 'table-options-grid';

                availableTables.forEach(table => {
                    const isReserved = reservedTableIds.includes(table.id);
                    const guestNumber = table.guest_number || table.capacity || 1;
                    const location = table.location || 'Intérieur';
                    
                    const tableCard = document.createElement('div');
                    tableCard.className = `table-item ${isReserved ? 'reserved' : 'available'}`;
                    tableCard.setAttribute('data-table-id', table.id);

                    let cardContent = `
                        <i class="fas fa-chair table-item-icon"></i>
                        <div class="table-item-capacity">${guestNumber} place${guestNumber > 1 ? 's' : ''}</div>
                        <div class="table-item-location">${location}</div>
                    `;

                    if (isReserved) {
                        cardContent += `<div class="table-item-status">Réservée</div>`;
                    } else {
                        cardContent += `<div class="table-item-status">Disponible</div>
                                      <input type="radio" id="table_${table.id}" name="table_id" value="${table.id}" required>`;
                    }
                    
                    tableCard.innerHTML = cardContent;

                    if (!isReserved) {
                        tableCard.addEventListener('click', function() {
                            // Désélectionner les autres cartes
                            document.querySelectorAll('.table-item.selected').forEach(card => {
                                card.classList.remove('selected');
                            });
                            
                            // Sélectionner la carte cliquée
                            this.classList.add('selected');
                            
                            // Cocher le bouton radio correspondant
                            const radio = this.querySelector('input[type="radio"]');
                            if(radio) radio.checked = true;
                        });
                    }
                    
                    grid.appendChild(tableCard);
                });

                tableOptionsContainer.appendChild(grid);

                // Sélectionner automatiquement la première table disponible
                const firstAvailableCard = grid.querySelector('.table-item.available');
                if (firstAvailableCard) {
                    firstAvailableCard.click();
                }

            })
            .catch(error => {
                console.error("Erreur lors de la récupération des tables :", error);
                tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Erreur lors du chargement des tables. Veuillez réessayer.</p>';
            });
        }

        // Événements pour la réservation
        dateInput.addEventListener('change', updateAvailableTables);
        timeInputs.forEach(input => {
            input.addEventListener('change', updateAvailableTables);
        });

        // Validation du formulaire de réservation
        reservationForm.addEventListener('submit', function(event) {
            const selectedTable = document.querySelector('input[name="table_id"]:checked');
            if (!selectedTable) {
                event.preventDefault();
                // Afficher un message plus élégant qu'une alerte si possible
                const tableErrorMsg = document.createElement('p');
                tableErrorMsg.textContent = 'Veuillez sélectionner une table disponible.';
                tableErrorMsg.style.color = 'red';
                tableErrorMsg.style.textAlign = 'center';
                tableOptionsContainer.appendChild(tableErrorMsg);
                setTimeout(() => tableErrorMsg.remove(), 3000);
                return;
            }
        });

        console.log("Script de réservation chargé avec système de commentaires et design de table amélioré.");
    });
    </script>
@endsection