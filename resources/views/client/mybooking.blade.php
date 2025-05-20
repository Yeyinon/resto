@extends('master')

@section('guest')
<title>Resto - Mes réservations</title>

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
        --danger-hover: #dc2626;
    }

    /* Page title section */
    .page-title-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        padding: 40px 0;
        color: white;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }

    .page-title-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 60%);
        transform: rotate(-30deg);
    }

    .page-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    /* Conteneur principal */
    .reservation-container {
        padding: 40px 0 60px;
    }

    /* Style des cartes de réservation */
    .reservation-card {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 8px 20px var(--shadow-color);
        margin-bottom: 30px;
        transition: all 0.3s ease;
        background: white;
    }

    .reservation-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(16, 185, 129, 0.2);
    }

    /* En-tête de la carte */
    .reservation-header {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 25px;
        font-size: 1.5rem;
        font-weight: 600;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .reservation-header::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    }

    /* Corps de la carte */
    .reservation-body {
        padding: 30px;
    }

    /* Sections d'information */
    .info-section {
        margin-bottom: 15px;
    }

    .info-section strong {
        display: block;
        margin-top: 18px;
        margin-bottom: 8px;
        color: var(--primary-color);
        font-size: 1.1rem;
        position: relative;
        padding-left: 20px;
    }

    .info-section strong::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 12px;
        height: 12px;
        background-color: var(--primary-light);
        border-radius: 50%;
    }

    .info-section p {
        margin-bottom: 8px;
        color: #555;
        padding-left: 20px;
    }

    /* Badge Yums */
    .yums-badge {
        font-size: 0.9rem;
        padding: 6px 12px;
        border-radius: 20px;
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
        color: white;
        display: inline-block;
        margin-top: 5px;
        margin-left: 20px;
        box-shadow: 0 2px 5px rgba(16, 185, 129, 0.2);
    }

    /* Bouton d'annulation */
    .cancel-btn {
        background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-hover) 100%);
        border: none;
        padding: 12px 25px;
        font-size: 1rem;
        font-weight: 500;
        border-radius: 50px;
        color: white;
        margin-top: 25px;
        width: 200px;
        text-align: center;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);
    }

    .cancel-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(239, 68, 68, 0.25);
        color: white;
        text-decoration: none;
    }

    .cancel-btn i {
        margin-right: 8px;
    }

    /* Style du modal */
    .modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-hover) 100%);
        color: white;
        border-bottom: none;
        padding: 20px 25px;
    }

    .modal-title {
        font-weight: 600;
    }

    .modal-body {
        padding: 25px;
        font-size: 1.05rem;
        color: #444;
    }

    .modal-footer {
        border-top: none;
        padding: 15px 25px 25px;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: #d1d5db;
    }

    .btn-danger-custom {
        background: linear-gradient(135deg, var(--danger-color) 0%, var(--danger-hover) 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }

    .btn-danger-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);
    }

    /* Message quand pas de réservations */
    .empty-reservations {
        text-align: center;
        padding: 50px 20px;
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 8px 20px var(--shadow-color);
    }

    .empty-reservations i {
        font-size: 4rem;
        color: var(--primary-light);
        margin-bottom: 20px;
        display: block;
    }

    .empty-reservations h5 {
        color: var(--text-dark);
        font-size: 1.5rem;
        font-weight: 500;
        margin-bottom: 15px;
    }

    .empty-reservations p {
        color: #6b7280;
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto;
    }
</style>

<!-- Page Title Section -->
<div class="page-title-section">
    <div class="container">
        <h1 class="page-title">Mes Réservations</h1>
        <div class="breadcrumb-modern">
            <a href="/" class="breadcrumb-item">Accueil</a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <span class="breadcrumb-item active">Mes Réservations</span>
        </div>
    </div>
</div>

<div class="container reservation-container">
    @if ($reservations->isEmpty())
        <div class="empty-reservations">
            <i class="far fa-calendar-times"></i>
            <h5>Aucune réservation pour le moment</h5>
            <p>Découvrez nos restaurants partenaires et réservez votre table en quelques clics.</p>
            <a href="{{ route('view_all') }}" class="btn-primary-custom mt-4">
                <i class="fas fa-utensils"></i> Découvrir les restaurants
            </a>
        </div>
    @else
        <div class="content-card mb-4">
            <p class="mb-0"><i class="fas fa-info-circle text-primary mr-2"></i> Vous pouvez annuler une réservation uniquement entre <strong>24h et 48h</strong> avant la date prévue.</p>
        </div>

        @foreach ($reservations as $reservation)
            <div class="reservation-card">
                <div class="reservation-header">
                    <i class="fas fa-utensils mr-2"></i> {{ $reservation->table->restaurant->name }}
                </div>
                <div class="reservation-body">
                    <div class="info-section">
                        <strong><i class="fas fa-coins mr-2"></i>Yums</strong>
                        <div class="yums-badge">{{ $reservation->table->restaurant->yums }} points</div>

                        <strong><i class="fas fa-chair mr-2"></i>Table</strong>
                        <p>Numéro : {{ $reservation->table->number }}</p>
                        <p>Emplacement : {{ $reservation->table->location }}</p>
                        <p>Nombre de personnes : {{ $reservation->table->guest_number }}</p>

                        <strong><i class="fas fa-clipboard-list mr-2"></i>Détails de réservation</strong>
                        <p>Téléphone : {{ $reservation->reservation_tele }}</p>
                        <p>Email : {{ $reservation->reservation_email }}</p>
                        <p>Date : {{ $reservation->reservation_date }}</p>
                        <p>Heure : {{ $reservation->reservation_time }}</p>
                    </div>

                    <a data-bs-toggle="modal" href="#cancelModal_{{ $reservation->id }}" class="cancel-btn">
                        <i class="fas fa-times-circle"></i> Annuler
                    </a>
                </div>
            </div>

            <!-- Modal Annulation -->
            <div class="modal fade" id="cancelModal_{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelModalLabel">Annuler la réservation</h5>
                            <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Fermer"></button>
                        </div>
                        <div class="modal-body">
                            <p><i class="fas fa-exclamation-triangle mr-2 text-warning"></i> Voulez-vous vraiment annuler cette réservation ?</p>
                            <p>Cela n'est possible que si la demande est faite entre <strong>24h et 48h</strong> avant la date de réservation.</p>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Retour</button>
                            <form action="{{ route('reservation.cancel', ['id' => $reservation->id]) }}" method="POST">
                                @csrf
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                                <button type="submit" class="btn btn-danger-custom">Confirmer l'annulation</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection