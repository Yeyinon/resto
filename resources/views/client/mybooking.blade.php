@extends('client.master')

@section('client')
<title>Resto - Mes réservations</title>

<style>
    .reservation-container {
        padding: 50px 0;
    }
    .reservation-card {
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        transition: transform 0.3s, box-shadow 0.3s;
        background: #fff;
    }
    .reservation-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
    }
    .reservation-header {
        background: linear-gradient(135deg, #4CAF50, #66BB6A); /* Vert clair */
        color: white;
        padding: 25px;
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
    }
    .reservation-body {
        padding: 25px;
    }
    .info-section strong {
        display: block;
        margin-top: 15px;
        color: #4CAF50; /* Vert clair */
    }
    .info-section p {
        margin-bottom: 8px;
        color: #555;
    }
    .yums-badge {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 12px;
        background-color: #66BB6A;
        color: white;
        display: inline-block;
        margin-top: 5px;
    }
    .cancel-btn {
        background-color: #ff5722; /* Rouge orangé */
        border: none;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 50px;
        color: white;
        margin-top: 20px;
        width: 200px;
        text-align: center;
    }
    .cancel-btn:hover {
        background-color: #ff5722; /* Reste la même couleur au survol */
        color: white;
    }
    .reservation-card:hover .cancel-btn {
        background-color: #ff5722;
    }
</style>

<div class="container reservation-container">
    <h1 class="text-center" style="color: #4CAF50; margin-bottom: 50px;">📅 Mes Réservations</h1>

    @if ($reservations->isEmpty())
        <div class="text-center my-5">
            <h5>Aucune réservation pour le moment</h5>
        </div>
    @endif

    @foreach ($reservations as $reservation)
        <div class="reservation-card">
            <div class="reservation-header">
                {{ $reservation->table->restaurant->name }}
            </div>
            <div class="reservation-body">
                <div class="info-section">
                    <strong>Yums :</strong>
                    <div class="yums-badge">{{ $reservation->table->restaurant->yums }}</div>

                    <strong>Table :</strong>
                    <p>Numéro : {{ $reservation->table->number }}</p>
                    <p>Emplacement : {{ $reservation->table->location }}</p>
                    <p>Nombre de personnes : {{ $reservation->table->guest_number }}</p>

                    <strong>Réservation :</strong>
                    <p>Téléphone : {{ $reservation->reservation_tele }}</p>
                    <p>Email : {{ $reservation->reservation_email }}</p>
                    <p>Date : {{ $reservation->reservation_date }}</p>
                    <p>Heure : {{ $reservation->reservation_time }}</p>
                </div>

                <a data-toggle="modal" href="#cancelModal_{{ $reservation->id }}" class="cancel-btn">
                    <i class="fas fa-times-circle"></i> Annuler
                </a>
            </div>
        </div>

        <!-- Modal Annulation -->
        <div class="modal fade" id="cancelModal_{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #ff5722; color: white;">
                        <h5 class="modal-title" id="cancelModalLabel">Annuler la réservation</h5>
                        <button class="close text-white" type="button" data-dismiss="modal" aria-label="Fermer">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment annuler cette réservation ?<br>
                        Cela n'est possible que si la demande est faite entre <strong>24h et 48h</strong> avant la date de réservation.
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Retour</button>
                        <form action="{{ route('reservation.cancel', ['id' => $reservation->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                            <button type="submit" class="btn" style="background-color: #ff5722; color: white;">Confirmer l'annulation</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<!-- FontAwesome + Bootstrap scripts -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
