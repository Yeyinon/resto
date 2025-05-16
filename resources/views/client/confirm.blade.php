@extends('master')
@section('guest')
<title>Resto - Réservation Confirmée</title>

<!-- Page Title Section -->
<div class="page-title-section">
    <div class="container">
        <h1 class="page-title">Réservation Confirmée</h1>
        <div class="breadcrumb-modern">
            <a href="/" class="breadcrumb-item">Accueil</a>
            <span class="breadcrumb-separator"><i class="fas fa-chevron-right"></i></span>
            <span class="breadcrumb-item active">Confirmation</span>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="container-custom">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="content-card text-center">
                    <div class="confirmation-icon mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 72 72">
                            <g fill="none" stroke="#10b981" stroke-width="3">
                                <circle cx="36" cy="36" r="33" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 0px;">
                                    <animate attributeName="stroke-dashoffset" from="240" to="0" dur="1.5s" begin="0s" fill="freeze" />
                                </circle>
                                <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;" stroke-linecap="round" stroke-linejoin="round">
                                    <animate attributeName="stroke-dashoffset" from="50" to="0" dur="0.6s" begin="1s" fill="freeze" />
                                </path>
                            </g>
                        </svg>
                    </div>
                    
                    <h2 class="mb-3" style="color: var(--primary-color); font-weight: 600;">Réservation Envoyée!</h2>
                    <p class="mb-4" style="font-size: 1.1rem; color: var(--text-dark);">Votre réservation est en attente de confirmation. Nous vous notifierons dès que le restaurant aura confirmé votre demande.</p>
                    
                    <div class="confirmation-actions">
                        <a href="{{ route('client.reservations') }}" class="btn-primary-custom mb-3 w-100">
                            <i class="fas fa-list-alt"></i> Voir mes réservations
                        </a>
                        
                        <a href="{{ route('client.menu', ['restaurant_id' => $restaurant->id]) }}" class="btn-primary-custom w-100">
                            <i class="fas fa-utensils"></i> Commander au restaurant
                        </a>
                        
                        <a href="/" class="d-block mt-4 text-decoration-none" style="color: var(--primary-color);">
                            <i class="fas fa-arrow-left me-2"></i> Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styles spécifiques à la page de confirmation */
    .confirmation-icon {
        display: flex;
        justify-content: center;
        margin-bottom: 30px;
    }
    
    .confirmation-actions {
        margin-top: 30px;
    }
    
    .btn-primary-custom {
        margin-bottom: 15px;
        justify-content: center;
    }
    
    /* Animation effect for the card */
    .content-card {
        animation: fadeInUp 0.6s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endsection