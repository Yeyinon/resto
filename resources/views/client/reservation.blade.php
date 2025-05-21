@extends('master')
@section('guest')
    <title>Resto - Reservation</title>
    
    <!-- Section titre de la page -->
    <div class="page-title-section">
        <div class="container">
            <h1 class="page-title">Réservation</h1>
            <div class="breadcrumb-modern">
                <a href="/" class="breadcrumb-item">Accueil</a>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <a href="{{ route('view_all') }}" class="breadcrumb-item">Restaurants</a>
                <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
                <span class="breadcrumb-item active">Réservation</span>
            </div>
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

                    <!-- Menu du restaurant -->
                    <div class="content-card">
                    <div class="menu-section">
                        <h3><i class="fas fa-utensils"></i> Menu du restaurant</h3>
                        
                        @if(isset($menus) && $menus->count() > 0)
    <div class="menu-items">
        @foreach($menus as $menu)
            <h4>{{ $menu->name }}</h4>
            <ul>
                @foreach($menu->plats as $plat)
                    <li>{{ $plat->name }} - {{ number_format($plat->price, 2) }} €</li>
                @endforeach
            </ul>
        @endforeach
    </div>
@else
    <div class="menu-empty">
        <p><i class="fas fa-info-circle"></i> Ce restaurant n'a pas encore ajouté son menu. Contactez-le directement pour plus d'informations sur les plats proposés.</p>
    </div>
@endif
                    </div>
                </div>
                    <!-- Section commentaires -->
                    <div class="content-card">
                        <div class="comment-section">
                            <h3><i class="fas fa-comments"></i> Avis et commentaires</h3>
                            
                            <!-- Formulaire de commentaire -->
                            <div class="comment-form">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                                    <input type="hidden" name="client_id" value="{{ Auth::guard('client')->id() }}">
                                    <div class="form-group">
                                        <label for="comment">Votre avis</label>
                                        <textarea name="comment" id="comment" required class="form-control" rows="4"
                                            placeholder="Partagez votre expérience pour aider les autres utilisateurs"></textarea>
                                    </div>
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="fas fa-paper-plane"></i> Publier
                                    </button>
                                </form>
                            </div>
                            
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
                                                <span class="comment-date">{{ $comment->created_at->format('d/m/Y H:i') }}</span>
                                            </div>
                                            <p>{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
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
                                @csrf
                                <input type="hidden" name="client_id" value="{{ Auth::guard('client')->id() }}">
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

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
                                
                                <div class="form-group">
                                    <label><i class="fas fa-phone"></i> Téléphone</label>
                                    <input class="form-control" required type="text" name="reservation_tele"
                                        placeholder="Votre téléphone">
                                </div>

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
        /* Styles spécifiques à la page de réservation */
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
        
        /* Reservation section */
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
        
        /* Style pour bouton primary sur toute la largeur */
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
        
        // Vérifier si date et heure sont sélectionnées
        if (!selectedDate || !selectedTime) {
            tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Veuillez d\'abord sélectionner une date et une heure</p>';
            return;
        }
        
        // Afficher un message de chargement
        tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Chargement des tables disponibles...</p>';
        
        // Faire une requête pour obtenir les tables disponibles
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
            // Debug: afficher les données reçues dans la console
            console.log("Données reçues:", data);
            
            // Vider le conteneur
            tableOptionsContainer.innerHTML = '';
            
            // Utiliser les bonnes clés selon la structure de votre réponse JSON
            const availableTables = data.tables || [];
            const reservedTableIds = data.reservées || [];
            
            if (availableTables.length === 0) {
                tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Aucune table disponible à cette date et heure</p>';
                return;
            }
            
            // Grouper les tables par nombre de personnes
            const tablesByCapacity = {};
            availableTables.forEach(table => {
                const capacity = table.guest_number || table.capacity;
                if (!tablesByCapacity[capacity]) {
                    tablesByCapacity[capacity] = [];
                }
                tablesByCapacity[capacity].push(table);
            });
            
            // Créer les options de table
            Object.keys(tablesByCapacity).sort((a, b) => a - b).forEach(capacity => {
                const tables = tablesByCapacity[capacity];
                
                tables.forEach(table => {
                    const isReserved = reservedTableIds.includes(table.id);
                    const tableDiv = document.createElement('div');
                    tableDiv.className = `table-option ${isReserved ? 'reserved' : 'available'}`;
                    
                    // Utiliser la propriété correcte pour le nombre de personnes
                    const guestNumber = table.guest_number || table.capacity;
                    
                    if (isReserved) {
                        // Table réservée - non sélectionnable
                        tableDiv.innerHTML = `
                            <div class="table-option-content">
                                <div class="table-option-details">
                                    <strong>${guestNumber} personne${guestNumber > 1 ? 's' : ''}</strong>
                                    <span class="table-status">
                                        <i class="fas fa-times-circle"></i> Réservée
                                    </span>
                                </div>
                                <div class="table-option-location">
                                    <i class="fas fa-map-marker-alt"></i> ${table.location}
                                </div>
                            </div>
                        `;
                    } else {
                        // Table disponible - sélectionnable
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
                                        <i class="fas fa-map-marker-alt"></i> ${table.location}
                                    </div>
                                </div>
                            </label>
                        `;
                        
                        // Rendre toute la div clickable pour sélectionner la radio
                        tableDiv.addEventListener('click', function() {
                            const radio = this.querySelector('input[type="radio"]');
                            if (radio) {
                                radio.checked = true;
                                // Mettre en évidence la table sélectionnée
                                document.querySelectorAll('.table-option.available').forEach(el => {
                                    el.style.boxShadow = 'none';
                                });
                                this.style.boxShadow = '0 0 0 2px var(--primary-color)';
                            }
                        });
                    }
                    
                    tableOptionsContainer.appendChild(tableDiv);
                });
            });
            
            // S'assurer qu'au moins une table est sélectionnée si disponible
            const firstAvailableRadio = tableOptionsContainer.querySelector('input[type="radio"]');
            if (firstAvailableRadio) {
                firstAvailableRadio.checked = true;
                firstAvailableRadio.closest('.table-option').style.boxShadow = '0 0 0 2px var(--primary-color)';
            }
        })
        .catch(error => {
            console.error("Erreur lors de la récupération des tables :", error);
            tableOptionsContainer.innerHTML = '<p class="select-date-time-message">Erreur lors du chargement des tables. Veuillez réessayer.</p>';
        });
    }
    
    // Ajouter les écouteurs d'événements
    dateInput.addEventListener('change', updateAvailableTables);
    timeInputs.forEach(input => {
        input.addEventListener('change', updateAvailableTables);
    });
    
    // Validation du formulaire avant soumission
    reservationForm.addEventListener('submit', function(event) {
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
        }
    });
    
    // Ajout de debug pour vérifier les événements
    console.log("Script de réservation chargé et amélioré");
});
    </script>
@endsection