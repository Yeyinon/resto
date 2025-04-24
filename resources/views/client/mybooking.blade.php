@extends('client.master')

@section('client')
    <title>Resto - Mes réservations</title>

    <main>
        <div class="container margin_detail">
            <div class="row">
                <h2 class="text-center text-primary my-5">Mes réservations :</h2>

                @if ($reservations->isEmpty())
                    <div class="text-center my-5">
                        <h5>Aucune réservation pour le moment</h5>
                    </div>
                @endif

                @foreach ($reservations as $reservation)
                    <div class="card shadow-lg mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #f2f2f2, #ffffff);">
                        <div class="card-body">
                            <h4 class="card-title text-primary">{{ $reservation->table->restaurant->name }}</h4>

                            <div class="d-flex flex-column mb-3">
                                <strong class="text-muted">Yums :</strong>
                                <!-- Badge Yums ajusté -->
                                <div class="badge badge-success mb-2" style="font-size: 0.8rem; padding: 3px 6px; border-radius: 12px; align-self: flex-start;">
                                    {{ $reservation->table->restaurant->yums }}
                                </div>
                            </div>

                            <div class="d-flex flex-column mb-3">
                                <strong class="text-muted">Table :</strong>
                                <p>Numéro : {{ $reservation->table->number }}</p>
                                <p>Emplacement : {{ $reservation->table->location }}</p>
                                <p>Nombre de personnes : {{ $reservation->table->guest_number }}</p>
                            </div>

                            <div class="d-flex flex-column mb-3">
                                <strong class="text-muted">Réservation :</strong>
                                <p>Téléphone : {{ $reservation->reservation_tele }}</p>
                                <p>E-mail : {{ $reservation->reservation_email }}</p>
                                <p>Date : {{ $reservation->reservation_date }}</p>
                                <p>Heure : {{ $reservation->reservation_time }}</p>
                            </div>

                            <!-- Bouton d'annulation ajusté -->
                            <a data-toggle="modal" href="#cancelModal_{{ $reservation->id }}" class="btn btn-danger mt-2" style="width: 160px; padding: 6px 10px; text-align: left; display: inline-block;">
                                <i class="fas fa-times-circle"></i> Annuler la réservation
                            </a>
                        </div>
                    </div>

                    <!-- Modal d'annulation -->
                    <div class="modal fade" id="cancelModal_{{ $reservation->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
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
                                        <button type="submit" class="btn btn-danger">Annuler la réservation</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>
    </main>

    <!-- Ajouter les liens pour les icônes FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    
    <!-- Inclure Bootstrap pour les styles et modals -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
