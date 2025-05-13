@extends('restaurant.master')
@section('restaurant')
    <div class="content-wrapper">
        <div class="reservations-container">
            <!-- En-tête avec effet dégradé -->
            <div class="header-banner">
                <div class="header-content">
                    <h1 class="profile-title">Gestion des Réservations</h1>

                    <!-- Fil d'ariane amélioré -->
                    <div class="breadcrumb-modern">
                        <a href="{{ route('restaurant.dashboard') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Réservations</span>
                    </div>
                </div>
            </div>

            <!-- Carte principale des réservations avec effet d'ombre -->
            <div class="reservations-card">
                <div class="reservations-header">
                    <div class="reservations-icon-container">
                        <div class="reservations-icon-circle">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <h2 class="reservations-subtitle">Liste des Réservations</h2>
                    <p class="reservations-description">Gérez les demandes de réservation de votre restaurant</p>
                </div>

                <div class="reservations-divider"></div>

                <div class="table-responsive">
                    <table class="data-table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="number">Numéro de table</th>
                                <th>Emplacement</th>
                                <th>Nom du client</th>
                                <th>E-mail du client</th>
                                <th>Téléphone</th>
                                <th>Date</th>
                                <th>Heure</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reservations as $reservation)
                                <tr>
                                    <td>{{ $reservation->table->number }}</td>
                                    <td class="location">{{ $reservation->table->location }}</td>
                                    <td class="prenom-client">{{ $reservation->client->name ?? 'Client inconnu' }}</td>
                                    <td>{{ $reservation->client->email ?? 'Email inconnu' }}</td>
                                    <td>{{ $reservation->reservation_tele }}</td>
                                    <td class="date">{{ $reservation->reservation_date }}</td>
                                    <td>{{ $reservation->reservation_time }}</td>
                                    <td class="actions-cell">
                                        <form action="{{ route('restaurant.reservation.approve', $reservation->id) }}"
                                            method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn-action approve">
                                                <i class="fas fa-check"></i> Approuver
                                            </button>
                                        </form>
                                        <button type="button" class="btn-action reject"
                                            onclick="openRejectModal('{{ $reservation->id }}')">
                                            <i class="fas fa-times"></i> Rejeter
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    <i class="fas fa-clock"></i> Dernière mise à jour: hier à 23:59
                </div>
            </div>
        </div>
    </div>

    <!-- Modals pour chaque réservation -->
    @foreach($reservations as $reservation)
        <!-- Modal de rejet -->
        <div class="modal" id="rejectModal_{{ $reservation->id }}" tabindex="-1" role="dialog"
            aria-labelledby="rejectModalLabel_{{ $reservation->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header delete-header">
                        <h5 class="modal-title" id="rejectModalLabel_{{ $reservation->id }}">
                            <i class="fas fa-exclamation-triangle modal-icon"></i> Motif du refus
                        </h5>
                        <button type="button" class="close" onclick="closeRejectModal('{{ $reservation->id }}')"
                            aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="modal-description">Veuillez indiquer la raison pour laquelle vous rejetez cette réservation.
                        </p>

                        <form action="{{ route('restaurant.reservation.reject', $reservation->id) }}" method="POST"
                            class="modal-form">
                            @csrf
                            <div class="form-group">
                                <label for="reason_{{ $reservation->id }}">
                                    <i class="fas fa-comment-alt form-icon"></i> Motif
                                </label>
                                <textarea id="reason_{{ $reservation->id }}" name="reason" class="form-control" rows="4"
                                    placeholder="Indiquez la raison du refus..." required></textarea>
                            </div>

                            <div class="form-action modal-action">
                                <button type="button" class="btn-cancel" onclick="closeRejectModal('{{ $reservation->id }}')">
                                    <i class="fas fa-times"></i> Annuler
                                </button>
                                <button type="submit" class="btn-delete">
                                    <i class="fas fa-ban"></i> Rejeter
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .prenom-client, .date, .location, .number{
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
            cursor: default;
            position: relative;
        }

        .prenom-client:hover {
            white-space: normal;
            /* Permet le retour à la ligne */
            overflow: visible;
            /* Affiche tout le texte */
            background: #fff;
            /* Fond blanc pour lisibilité */
            z-index: 10;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3);
            position: absolute;
            /* Sort de la grille pour ne pas casser la mise en page */
            max-width: 300px;
            /* Largeur max au survol */
            padding: 5px;
            border-radius: 4px;
        }
        
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
            --success-color: #10b981;
            --success-dark: #065f46;
            --success-light: #d1fae5;
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

        .reservations-container {
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
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 60%);
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
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Fil d'ariane amélioré */
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1rem;
        }

        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.9);
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

        /* Carte principale des réservations */
        .reservations-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px var(--shadow-color);
            padding: 30px;
            margin-bottom: 30px;
            position: relative;
            z-index: 1;
        }

        .reservations-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            text-align: center;
        }

        .reservations-icon-container {
            margin-bottom: 15px;
        }

        .reservations-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }

        .reservations-icon-circle i {
            font-size: 2rem;
            color: white;
        }

        .reservations-subtitle {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .reservations-description {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .reservations-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            margin: 15px 0 30px;
        }

        /* Style du tableau */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            /* Ajoute le scroll horizontal si besoin */
            -webkit-overflow-scrolling: touch;
            /* Pour un scroll fluide sur mobile */
        }


        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        .data-table thead {
            background-color: var(--table-header);
        }

        .data-table th {
            color: var(--text-dark);
            font-weight: 600;
            padding: 15px;
            text-align: left;
            border-bottom: 2px solid var(--primary-light);
        }

        .data-table td {
            padding: 15px;
            border-bottom: 1px solid var(--table-border);
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background-color: var(--table-hover);
        }

        /* Boutons d'action */
        .actions-cell {
            display: flex;
            gap: 10px;
            align-items: center;
            /* Centrage vertical */
        }


        .btn-action {
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            border: none;
            display: flex;
            align-items: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-action i {
            margin-right: 5px;
        }

        .btn-action.approve {
            background-color: var(--success-light);
            color: var(--success-dark);
        }

        .btn-action.approve:hover {
            background-color: var(--success-color);
            color: white;
        }

        .btn-action.reject {
            background-color: var(--danger-light);
            color: var(--danger-dark);
        }

        .btn-action.reject:hover {
            background-color: var(--danger-color);
            color: white;
        }

        /* Footer de la carte */
        .card-footer {
            margin-top: 20px;
            padding-top: 15px;
            color: #6b7280;
            font-size: 0.85rem;
            border-top: 1px solid var(--table-border);
        }

        .card-footer i {
            margin-right: 5px;
        }

        /* Styles des modals */
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            background-color: white;
            margin: 10% auto;
            width: 90%;
            max-width: 500px;
            position: relative;
            animation: modalFadeIn 0.3s ease-out;
        }

        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .modal-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            padding: 15px 20px;
            border-bottom: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-header.delete-header {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-dark) 100%);
        }

        .modal-title {
            font-weight: 600;
            display: flex;
            align-items: center;
            margin: 0;
        }

        .modal-icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .modal-header .close {
            color: white;
            opacity: 0.8;
            text-shadow: none;
            transition: all 0.2s ease;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            padding: 0;
            margin: 0;
        }

        .modal-header .close:hover {
            opacity: 1;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-description {
            color: #6b7280;
            margin-bottom: 20px;
        }

        /* Formulaire dans modal */
        .modal-form .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--background-light);
            resize: vertical;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }

        .form-icon {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .modal-action {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn-cancel {
            background-color: #e5e7eb;
            color: #4b5563;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background-color: #d1d5db;
        }

        .btn-delete {
            background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #f87171, var(--danger-dark) 100%);
        }

        .btn-cancel i,
        .btn-delete i {
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .actions-cell {
                flex-direction: column;
                gap: 5px;
            }

            .header-banner {
                padding: 20px;
            }

            .profile-title {
                font-size: 1.8rem;
            }

            .modal-content {
                width: 95%;
                margin: 15% auto;
            }

            .data-table {
                font-size: 0.85rem;
            }

            .data-table th,
            .data-table td {
                padding: 10px 8px;

            }
        }

        @media (max-width: 992px) {
            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>

    <!-- JavaScript pour contrôler les modals -->
    <script>
        // Fonctions pour gérer les modals sans dépendre de Bootstrap
        function openRejectModal(reservationId) {
            document.getElementById('rejectModal_' + reservationId).style.display = 'block';
            document.body.style.overflow = 'hidden'; // Empêche le défilement en arrière-plan
        }

        function closeRejectModal(reservationId) {
            document.getElementById('rejectModal_' + reservationId).style.display = 'none';
            document.body.style.overflow = 'auto'; // Réactive le défilement
        }

        // Fermer les modals si l'utilisateur clique en dehors
        window.onclick = function (event) {
            var allModals = document.getElementsByClassName('modal');
            for (var i = 0; i < allModals.length; i++) {
                if (event.target == allModals[i]) {
                    allModals[i].style.display = 'none';
                    document.body.style.overflow = 'auto';
                }
            }
        }

        // S'assurer que tous les modals sont fermés au chargement
        document.addEventListener('DOMContentLoaded', function () {
            var allModals = document.getElementsByClassName('modal');
            for (var i = 0; i < allModals.length; i++) {
                allModals[i].style.display = 'none';
            }
        });
    </script>
@endsection