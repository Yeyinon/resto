@extends('restaurant.master')

<style>
    .reservation-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn-approve {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 6px 12px;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-reject {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 6px 12px; /* corrigé ici */
        border-radius: 4px;
        cursor: pointer;
        margin-top: -19px;
    }

    .btn-approve:hover {
        background-color: #218838;
    }

    .btn-reject:hover {
        background-color: #c82333;
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>


@section('restaurant')
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Reservations</li>
            </ol>

            <!-- Example DataTables Card-->
            <div class="card mb-3">
                <div class="card-header">
                    <i class="fa fa-table"></i> Liste des reservations
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Numéro de table</th>
                                    <th>Emplacement du table</th>
                                    <th>Nom du client</th>
                                    <th>E-mail du client</th>
                                    <th>Téléphone du client</th>
                                    <th>Date de réservation</th>
                                    <th>Heure de réservation</th>
                                    <th>Actions</th> <!-- Nouvelle colonne pour les boutons -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Numéro de table</th>
                                    <th>Emplacement du table</th>
                                    <th>Nom du client</th>
                                    <th>E-mail du client</th>
                                    <th>Téléphone du client</th>
                                    <th>Date de réservation</th>
                                    <th>Heure de réservation</th>
                                    <th>Actions</th> <!-- Nouvelle colonne pour les boutons -->
                                </tr>
                            </tfoot>
                            <tbody>

                                @foreach($reservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->table->number }} </td>
                                        <td>{{ $reservation->table->location }} </td>
                                        <td>{{ $reservation->client->name ?? 'Client inconnu' }} </td>
                                        <td>{{ $reservation->client->email ?? 'Email inconnu' }} </td>
                                        <td>{{ $reservation->reservation_tele }} </td>
                                        <td>{{ $reservation->reservation_date }} </td>
                                        <td>{{ $reservation->reservation_time }}</td>
                                        <td class="reservation-actions">
                                            <form action="{{ route('restaurant.reservation.approve', $reservation->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-approve">Approuver</button>
                                            </form>
                                            <button type="button" class="btn-reject" data-toggle="modal"
                                                data-target="#rejectModal{{ $reservation->id }}">
                                                Rejeter
                                            </button>

                                        </td>
                                    </tr>

                                    <!-- Modal pour le motif du refus -->
                                    <div class="modal fade" id="rejectModal{{ $reservation->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="rejectModalLabel{{ $reservation->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form action="{{ route('restaurant.reservation.reject', $reservation->id) }}"
                                                method="POST">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="rejectModalLabel{{ $reservation->id }}">
                                                            Motif du refus</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Fermer">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea name="reason" class="form-control" rows="4"
                                                            placeholder="Indiquez la raison du refus..." required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Annuler</button>
                                                        <button type="submit" class="btn btn-danger">Rejeter</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            <!-- /tables-->
        </div>
        <!-- /container-fluid-->
    </div>
@endsection