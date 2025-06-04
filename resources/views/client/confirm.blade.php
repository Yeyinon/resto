@extends('master')
@section('guest')
    <title>Resto - Confirmation de réservation</title>
    
    <!-- Section titre de la page -->
    <div class="page-title-section">
    </div>

    <main class="main-content">
        <div class="container margin_detail">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="content-card confirmation-card">
                        <div class="confirmation-header">
                            <div class="success-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h2>Réservation envoyée !</h2>
                            <p>Votre table a été réservée et est en attente de confirmation</p>
                        </div>
                        
                        <div class="reservation-details">
                            <h3>Détails de votre réservation</h3>
                            
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-utensils"></i> Restaurant
                                </div>
                                <div class="detail-value">
                                    {{ $reservation->restaurant->name }}
                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-calendar-alt"></i> Date
                                </div>
                                <div class="detail-value">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d/m/Y') }}
                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-clock"></i> Heure
                                </div>
                                <div class="detail-value">
                                    {{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}
                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-table"></i> Table
                                </div>
                                <div class="detail-value">
                                    Table pour {{ $reservation->table->guest_number ?? $reservation->table->capacity ?? 1 }} personne(s)
                                    <br><small>{{ $reservation->table->location ?? 'Emplacement standard' }}</small>
                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-envelope"></i> Email
                                </div>
                                <div class="detail-value">
                                    {{ $reservation->reservation_email }}
                                </div>
                            </div>
                            
                            <div class="detail-row">
                                <div class="detail-label">
                                    <i class="fas fa-phone"></i> Téléphone
                                </div>
                                <div class="detail-value">
                                    {{ $reservation->reservation_tele }}
                                </div>
                            </div>
                            
                            <div class="detail-row yums-earned">
                                <div class="detail-label">
                                    <i class="fas fa-gift"></i> Yums gagnés
                                </div>
                                <div class="detail-value">
                                    +{{ $reservation->restaurant->yums }} yums
                                </div>
                            </div>
                        </div>
                        
                        <div class="confirmation-actions">
                            <a href="{{ route('client.reservations') }}" class="btn-primary-custom">
                                <i class="fas fa-list"></i> Voir mes réservations
                            </a>
                            <a href="{{ route('client.menu', ['restaurant_id' => $reservation->restaurant->id]) }}" class="btn-secondary-custom">
                                <i class="fas fa-utensils"></i> Commander Menu 
                            </a>
                        </div>
                        
                        <div class="confirmation-note">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle"></i>
                                <strong>Important :</strong> Un email de confirmation sera envoyé à {{ $reservation->reservation_email }}. 
                                Veuillez vous présenter à l'heure pour votre réservation.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
        /* Styles existants... */
        .confirmation-card {
            text-align: center;
            padding: 40px;
        }
        
        .confirmation-header {
            margin-bottom: 40px;
        }
        
        .success-icon {
            font-size: 4rem;
            color: #10b981;
            margin-bottom: 20px;
        }
        
        .confirmation-header h2 {
            color: #10b981;
            margin-bottom: 10px;
        }
        
        .confirmation-header p {
            color: #666;
            font-size: 1.1rem;
        }
        
        .reservation-details {
            text-align: left;
            margin: 40px 0;
        }
        
        .reservation-details h3 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--text-dark);
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            display: flex;
            align-items: center;
            min-width: 150px;
        }
        
        .detail-label i {
            margin-right: 8px;
            color: var(--primary-color);
            width: 16px;
        }
        
        .detail-value {
            text-align: right;
            color: var(--text-dark);
        }
        
        .yums-earned {
            background-color: #f0f9ff;
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #e0f2fe;
            margin-top: 20px;
        }
        
        .yums-earned .detail-value {
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .confirmation-actions {
            margin: 40px 0;
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn-secondary-custom {
            background-color: #6b7280;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-secondary-custom:hover {
            background-color: #4b5563;
            text-decoration: none;
            color: white;
        }
        
        .confirmation-note {
            margin-top: 30px;
        }
        
        .alert {
            padding: 15px;
            border-radius: 8px;
            text-align: left;
        }
        
        .alert-info {
            background-color: #dbeafe;
            border: 1px solid #93c5fd;
            color: #1e40af;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
        }
        
        @media (max-width: 768px) {
            .confirmation-card {
                padding: 20px;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
            
            .detail-label {
                min-width: auto;
            }
            
            .detail-value {
                text-align: left;
            }
            
            .confirmation-actions {
                flex-direction: column;
            }
        }
    </style>
@endsection