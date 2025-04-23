@extends('client.master')

@section('client')
    <title>Resto - Mes réservations</title>

    <main>
        <div class="container margin_detail">
            <div class="row">
                <h2 style="text-align: center">Mes réservations :</h2><br>

                @if ($reservations->isEmpty())
                    <br><br><br>
                    <h5 style="text-align: center">Aucune réservation pour le moment</h5>
                    <br><br><br>
                @endif

                @foreach ($reservations as $reservation)
                    <div>
                        <h5>Nom du restaurant : {{ $reservation->table->restaurant->name }}</h5><br>

                        <div class="menu_item">
                            <strong>Yums</strong>
                            <p>+ {{ $reservation->table->restaurant->yums }}</p>
                        </div>

                        <div class="menu_item">
                            <strong>Table</strong>
                            <p>Numéro : {{ $reservation->table->number }} <br>
                               Emplacement : {{ $reservation->table->location }} <br>
                               Nombre de personnes : {{ $reservation->table->guest_number }}</p>
                        </div>

                        <div class="menu_item">
                            <strong>Réservation Téléphone</strong>
                            <p>{{ $reservation->reservation_tele }}</p>
                        </div>

                        <div class="menu_item">
                            <strong>Réservation E-mail</strong>
                            <p>{{ $reservation->reservation_email }}</p>
                        </div>

                        <div class="menu_item">
                            <strong>Date de réservation</strong>
                            <p>{{ $reservation->reservation_date }}</p>
                        </div>

                        <div class="menu_item">
                            <strong>Heure de réservation</strong>
                            <p>{{ $reservation->reservation_time }}</p>
                        </div>

                        {{-- Lien pour ouvrir la modal d'annulation --}}
                        <a data-toggle="modal" href="#cancelModal_{{ $reservation->id }}">
                            <strong>Annuler la réservation</strong>
                        </a>
                        <hr>
                    </div>

                    <!-- Modal d'annulation -->
                    <div class="modal fade" id="cancelModal_{{ $reservation->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Annuler la réservation</h5>
                                    <button class="close" type="button" data-dismiss="modal" aria-label="Fermer">
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
@endsection
