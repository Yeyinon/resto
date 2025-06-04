@extends('master')
@section('guest')
    <title>Resto - Reservation</title>
    
    <!-- Section titre de la page -->
    <div class="page-title-section">
        <div class="container">
        </div>
    </div>

    <main class="main-content">
        <div class="container margin_detail">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Informations du restaurant -->
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
                                <a href="https://www.google.com/maps/search/{{ urlencode($restaurant->location) }}" target="_blank" class="btn-primary-custom">
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

                    <!-- Section commentaires -->
                    <div class="content-card">
                        <div class="comment-section">
                            <h3><i class="fas fa-comments"></i> Avis et commentaires</h3>
                            
                            <!-- Formulaire de commentaire -->
                            @auth('client')
                                <div class="comment-form" id="comment-form-container">
                                    <!-- Le formulaire sera affiché dynamiquement via JavaScript -->
                                </div>
                            @else
                                <div class="comment-form">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle"></i>
                                        <a href="{{ route('client.login') }}">Connectez-vous</a> pour laisser un avis après avoir honoré une réservation.
                                    </div>
                                </div>
                            @endauth
                            
                            <!-- Liste des commentaires -->
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
                
                <!-- Colonne de réservation -->
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
                                {{-- SUPPRIMER CETTE LIGNE : <input type="hidden" name="guest_number" id="guest_number_input"> --}}

                                <!-- Date de réservation -->
                                <div class="form-group">
                                    <label><i class="fas fa-calendar-alt"></i> Date</label>
                                    <input required class="form-control date-input" type="date" name="reservation_date"
                                        min="{{ date('Y-m-d') }}" id="reservation_date">
                                </div>

                                <!-- Heure de réservation -->
                                <div class="form-group">
                                    <label><i class="fas fa-clock"></i> Heure</label>
                                    <div class="time-slots">
                                        <div class="time-category">
                                            <h5>Déjeuner</h5>
                                            <div class="time-options">
                                                <div class="time-option">
                                                    <input type="radio" id="time_1" name="reservation_time" value="12:00:00">
                                                    <label for="time_1">12:00</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_2" name="reservation_time" value="12:30:00">
                                                    <label for="time_2">12:30</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_3" name="reservation_time" value="13:00:00">
                                                    <label for="time_3">13:00</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_4" name="reservation_time" value="13:30:00">
                                                    <label for="time_4">13:30</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_5" name="reservation_time" value="14:00:00">
                                                    <label for="time_5">14:00</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_6" name="reservation_time" value="14:30:00">
                                                    <label for="time_6">14:30</label>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="time-category">
                                            <h5>Dîner</h5>
                                            <div class="time-options">
                                                <div class="time-option">
                                                    <input type="radio" id="time_11" name="reservation_time" value="20:00:00">
                                                    <label for="time_11">20:00</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_12" name="reservation_time" value="20:30:00">
                                                    <label for="time_12">20:30</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_13" name="reservation_time" value="21:00:00">
                                                    <label for="time_13">21:00</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_14" name="reservation_time" value="21:30:00">
                                                    <label for="time_14">21:30</label>
                                                </div>
                                                <div class="time-option">
                                                    <input type="radio" id="time_15" name="reservation_time" value="22:00:00">
                                                    <label for="time_15">22:00</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sélection de table -->
                                <div class="form-group">
                                    <label><i class="fas fa-users"></i> Table</label>
                                    <div class="table-options" id="table-options">
                                        <p class="select-date-time-message">Veuillez d'abord sélectionner une date et une heure</p>
                                    </div>
                                </div>

                                <!-- Coordonnées -->
                                <div class="form-group">
                                    <label><i class="fas fa-envelope"></i> Email</label>
                                    <input class="form-control" required type="email" name="reservation_email"
                                        @if (Auth::guard('client')->check()) value="{{ Auth::guard('client')->user()->email }}" @else placeholder="Votre email" @endif>
                                </div>
                                
                                {{-- SUPPRIMER CES LIGNES DUPLIQUÉES --}}
                                {{-- <input type="hidden" name="client_id" value="{{ Auth::guard('client')->id() }}"> --}}
                                {{-- <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}"> --}}
                                {{-- <input type="hidden" name="guest_number" id="guest_number_input">  --}}
                                
                                <div class="form-group">
                                    <label for="reservation_tele">Téléphone *</label>
                                    <input type="text" id="reservation_tele" name="reservation_tele" class="form-control"
                                        value="{{ old('reservation_tele', Auth::guard('client')->user()->tele) }}" required>
                                    @error('reservation_tele')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                    @enderror
                                {{-- CORRECTION DE LA BALISE DIV MAL FERMÉE --}}
                                </div> 
                                {{-- <div class="form-group"></div> --}} {{-- SUPPRIMER CETTE LIGNE --}}

                                <!-- Bouton de réservation -->
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
        /* Styles existants... */
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
        
        .star-rating label:hover,
        .star-rating label.hover {
            color: #ffd700;
        }
        
        .star-rating input[type="radio"]:checked + label,
        .star-rating label.active {
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
        
        /* Styles pour la réservation (inchangés) */
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
        }
        
        .time-category {
            margin-bottom: 15px;
        }
        
        .time-category h5 {
            margin-bottom: 10px;
            color: var(--text-dark);
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
        }
        
        .time-option input[type="radio"]:checked + label {
            background-color: var(--primary-color);
            color: white;
        }
        
        .table-options {
            margin: 15px 0;
            max-height: 250px;
            overflow-y: auto;
        }
        
        .table-option {
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 6px;
            background-color: #f0f0f0;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }
        
        .table-option.available {
            background-color: #d1fae5;
            border: 1px solid #10b981;
        }
        
        .table-option.reserved {
            background-color: #fee2e2;
            border: 1px solid #ef4444;
            opacity: 0.7;
            cursor: not-allowed;
        }
        
        .table-option input[type="radio"] {
            position: absolute;
            opacity: 0;
        }
        
        .table-option input[type="radio"]:checked + label {
            box-shadow: 0 0 0 2px var(--primary-color);
        }
        
        .table-option-details {
            display: flex;
            justify-content: space-between;
        }
        
        .table-option-location {
            color: #777;
            font-size: 0.9rem;
        }
        
        .select-date-time-message {
            text-align: center;
            color: #777;
            padding: 20px 0;
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
        }
        
        .yums-info i {
            font-size: 1.8rem;
            color: var(--primary-color);
        }
        
        .btn-block {
            display: block;
            width: 100%;
        }
    </style>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const dateInput = document.getElementById('reservation_date');
        const timeInputs = document.querySelectorAll('input[name="reservation_time"]');
        const tableOptionsContainer = document.getElementById('table-options');
        const reservationForm = document.getElementById('reservationForm');
        const commentFormContainer = document.getElementById('comment-form-container');
        
        // Initialisation de guestNumberInput une fois le DOM chargé
        // guestNumberInput n'est plus nécessaire ici car le champ hidden est supprimé
        // const guestNumberInput = document.getElementById('guest_number_input'); // SUPPRIMER CETTE LIGNE
        // console.log('1. DOMContentLoaded: guestNumberInput trouvé?', guestNumberInput ? 'Oui' : 'Non', 'ID:', guestNumberInput ? guestNumberInput.id : 'N/A');
        // if (guestNumberInput) {
        //     console.log('2. DOMContentLoaded: Valeur initiale de guestNumberInput:', guestNumberInput.value);
        // }

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
                                <input type="radio" id="star5" name="rating" value="5" required>
                                <label for="star5" data-value="5">★</label>
                                <input type="radio" id="star4" name="rating" value="4">
                                <label for="star4" data-value="4">★</label>
                                <input type="radio" id="star3" name="rating" value="3">
                                <label for="star3" data-value="3">★</label>
                                <input type="radio" id="star2" name="rating" value="2">
                                <label for="star2" data-value="2">★</label>
                                <input type="radio" id="star1" name="rating" value="1">
                                <label for="star1" data-value="1">★</label>
                            </div>
                            <span id="rating-text">Cliquez pour noter</span>
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
            
            // Initialiser le système d'étoiles
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
            const starRating = document.getElementById('star-rating');
            const ratingText = document.getElementById('rating-text');
            const stars = starRating.querySelectorAll('label');
            const radioButtons = starRating.querySelectorAll('input[type="radio"]');
            
            // Messages pour chaque note
            const ratingMessages = {
                1: "Très décevant",
                2: "Décevant", 
                3: "Correct",
                4: "Très bien",
                5: "Excellent"
            };
            
            stars.forEach((star, index) => {
                // Survol des étoiles
                star.addEventListener('mouseenter', function() {
                    const value = this.getAttribute('data-value');
                    highlightStars(value);
                    ratingText.textContent = ratingMessages[value];
                });
                
                // Clic sur les étoiles
                star.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    radioButtons[5 - value].checked = true;
                    ratingText.textContent = ratingMessages[value];
                    ratingText.style.fontWeight = 'bold';
                    ratingText.style.color = '#ffd700';
                });
            });
            
            // Réinitialiser au survol de sortie
            starRating.addEventListener('mouseleave', function() {
                const checkedStar = starRating.querySelector('input[type="radio"]:checked');
                if (checkedStar) {
                    const value = checkedStar.value;
                    highlightStars(value);
                    ratingText.textContent = ratingMessages[value];
                } else {
                    resetStars();
                    ratingText.textContent = "Cliquez pour noter";
                    ratingText.style.fontWeight = 'normal';
                    ratingText.style.color = '#777';
                }
            });
            
            function highlightStars(rating) {
                stars.forEach((star, index) => {
                    const starValue = star.getAttribute('data-value');
                    if (starValue <= rating) {
                        star.style.color = '#ffd700';
                    } else {
                        star.style.color = '#ddd';
                    }
                });
            }
            
            function resetStars() {
                stars.forEach(star => {
                    star.style.color = '#ddd';
                });
            }
        }
        
        // Fonction pour mettre à jour les tables disponibles
        function updateAvailableTables() {
            const selectedDate = dateInput.value;
            let selectedTime = null;

            for (const timeInput of timeInputs) {
                if (timeInput.checked) {
                    selectedTime = timeInput.value;
                    break;
                }
            }

            console.log("3. updateAvailableTables: Date sélectionnée:", selectedDate);
            console.log("4. updateAvailableTables: Heure sélectionnée:", selectedTime);

            if (!selectedDate || !selectedTime) {
                tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Veuillez d\'abord sélectionner une date et une heure</p>';
                // guestNumberInput n'est plus pertinent ici
                // if (guestNumberInput) {
                //     guestNumberInput.value = ''; 
                //     console.log('5. updateAvailableTables: guest_number réinitialisé (date/heure manquantes):', guestNumberInput.value);
                // }
                return;
            }

            tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Chargement des tables disponibles...</p>';

            fetch(`/api/available-tables?restaurant_id={{ $restaurant->id }}&date=${selectedDate}&time=${selectedTime}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erreur réseau: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log("6. Données reçues de l'API:", data);

                tableOptionsContainer.innerHTML = '';

                const availableTables = data.tables || [];
                const reservedTableIds = data.reservées || [];

                if (availableTables.length === 0) {
                    tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Aucune table disponible à cette date et heure</p>';
                    // guestNumberInput n'est plus pertinent ici
                    // if (guestNumberInput) {
                    //     guestNumberInput.value = ''; 
                    //     console.log('7. updateAvailableTables: guest_number réinitialisé (aucune table disponible):', guestNumberInput.value);
                    // }
                    return;
                }

                const tablesByCapacity = {};
                availableTables.forEach(table => {
                    const capacity = table.guest_number || table.capacity || 1;
                    if (!tablesByCapacity[capacity]) {
                        tablesByCapacity[capacity] = [];
                    }
                    tablesByCapacity[capacity].push(table);
                });

                Object.keys(tablesByCapacity).sort((a, b) => a - b).forEach(capacity => {
                    const tables = tablesByCapacity[capacity];

                    tables.forEach(table => {
                        const isReserved = reservedTableIds.includes(table.id);
                        const tableDiv = document.createElement('div');
                        tableDiv.className = `table-option ${isReserved ? 'reserved' : 'available'}`;

                        const guestNumber = table.guest_number || table.capacity || 1;
                        const location = table.location || 'Emplacement non spécifié';

                        if (isReserved) {
                            tableDiv.innerHTML = `
                                <div class="table-option-content">
                                    <div class="table-option-details">
                                        <strong>${guestNumber} personne${guestNumber > 1 ? 's' : ''}</strong>
                                        <span class="table-status">
                                            <i class="fas fa-times-circle"></i> Réservée
                                        </span>
                                    </div>
                                    <div class="table-option-location">
                                        <i class="fas fa-map-marker-alt"></i> ${location}
                                    </div>
                                </div>
                            `;
                        } else {
                            tableDiv.innerHTML = `
                                <input type="radio" id="table_${table.id}" name="table_id" value="${table.id}" required>
                                <label for="table_${table.id}" class="table-label">
                                    <div class="table-option-content">
                                        <div class="table-option-details">
                                            <strong>${guestNumber} personne${guestNumber > 1 ? 's' : ''}</strong>
                                            <span class="table-status">
                                                <i class="fas fa-check-circle"></i> Disponible
                                            </span>
                                        </div>
                                        <div class="table-option-location">
                                            <i class="fas fa-map-marker-alt"></i> ${location}
                                        </div>
                                    </div>
                                </label>
                            `;

                            tableDiv.addEventListener('click', function() {
                                const radio = this.querySelector('input[type="radio"]');
                                if (radio) {
                                    radio.checked = true;
                                    document.querySelectorAll('.table-option.available').forEach(el => {
                                        el.style.boxShadow = 'none';
                                    });
                                    this.style.boxShadow = '0 0 0 2px var(--primary-color)';

                                    // guestNumberInput n'est plus pertinent ici
                                    // if (guestNumberInput) {
                                    //     guestNumberInput.value = guestNumber;
                                    //     console.log('8. guest_number mis à jour via clic:', guestNumberInput.value);
                                    // }
                                }
                            });
                        }

                        tableOptionsContainer.appendChild(tableDiv);
                    });
                });

                // Sélectionner automatiquement la première table disponible
                const firstAvailableRadio = tableOptionsContainer.querySelector('input[type="radio"]');
                console.log('firstAvailableRadio found?', firstAvailableRadio ? 'Yes' : 'No'); 
                if (firstAvailableRadio) {
                    firstAvailableRadio.checked = true;
                    firstAvailableRadio.closest('.table-option').style.boxShadow = '0 0 0 2px var(--primary-color)';
                    
                    const selectedTableId = firstAvailableRadio.value;
                    const selectedTable = availableTables.find(t => t.id == selectedTableId);
                    
                    // guestNumberInput n'est plus pertinent ici
                    // if (selectedTable && guestNumberInput) {
                    //     guestNumberInput.value = selectedTable.guest_number || selectedTable.capacity || 1;
                    //     console.log('9. guest_number mis à jour via sélection auto:', guestNumberInput.value);
                    // } else { 
                    //     console.log('9.1. Auto-selection: selectedTable ou guestNumberInput est null/undefined.', { selectedTable, guestNumberInput });
                    // }
                } else {
                    // guestNumberInput n'est plus pertinent ici
                    // if (guestNumberInput) {
                    //     guestNumberInput.value = ''; 
                    //     console.log('10. updateAvailableTables: guest_number réinitialisé (aucune table auto-sélectionnée):', guestNumberInput.value);
                    // }
                }
            })
            .catch(error => {
                console.error("11. Erreur lors de la récupération des tables :", error);
                tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Erreur lors du chargement des tables. Veuillez réessayer.</p>';
                // guestNumberInput n'est plus pertinent ici
                // if (guestNumberInput) {
                //     guestNumberInput.value = ''; 
                //     console.log('12. updateAvailableTables: guest_number réinitialisé (erreur API):', guestNumberInput.value);
                // }
            });
        }
        // Événements pour la réservation
        dateInput.addEventListener('change', updateAvailableTables);
        timeInputs.forEach(input => {
            input.addEventListener('change', updateAvailableTables);
        });

        // Validation du formulaire de réservation
        reservationForm.addEventListener('submit', function(event) {
            console.log('13. Soumission du formulaire détectée.');
            // guestNumberInput n'est plus pertinent ici, on ne le valide plus côté client
            // const currentGuestNumberInput = document.getElementById('guest_number_input');
            
            // console.log('14. Valeur de guestNumberInput.value AVANT soumission:', currentGuestNumberInput ? currentGuestNumberInput.value : 'guestNumberInput non trouvé');
            // console.log('14.1. currentGuestNumberInput est-il null?', currentGuestNumberInput === null); 
            // console.log('14.2. currentGuestNumberInput est-il undefined?', typeof currentGuestNumberInput === 'undefined'); 


            const selectedTable = document.querySelector('input[name="table_id"]:checked');
            const selectedDate = dateInput.value;
            let selectedTime = null;

            for (const timeInput of timeInputs) {
                if (timeInput.checked) {
                    selectedTime = timeInput.value;
                    break;
                }
            }

            if (!selectedDate || !selectedTime || !selectedTable) {
                event.preventDefault();
                alert('Veuillez sélectionner une date, une heure et une table pour effectuer votre réservation.');
                console.log('15. Soumission bloquée: Date, heure ou table manquante.');
                return;
            }
            
            // SUPPRIMER CETTE VALIDATION JAVASCRIPT POUR guest_number
            // if (!currentGuestNumberInput || currentGuestNumberInput.value === '' || isNaN(parseInt(currentGuestNumberInput.value)) || parseInt(currentGuestNumberInput.value) < 1) {
            //     event.preventDefault();
            //     alert('Le nombre d\'invités n\'a pas pu être déterminé ou est invalide. Veuillez sélectionner une table.');
            //     console.log('16. Soumission bloquée: guest_number invalide ou non déterminé.');
            //     return;
            // }
            console.log('17. Validation JavaScript passée. Tentative de soumission du formulaire.');
        });

        console.log("Script de réservation chargé avec système de commentaires");
    });
    </script>
    <style>
        .menu-item-photo {
            width: 100%;
            height: 150px; /* Ajustez la hauteur selon vos préférences */
            object-fit: cover; /* Assure que l'image couvre la zone sans déformation */
        }
        .menu-item-name {
            font-size: 1.1em;
            color: #333;
        }
        .menu-category h4 {
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
    </style>
@endsection
