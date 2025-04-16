@extends('restaurant.master')

<style>
    .reservation-actions {
    display: flex;
    gap: 10px; /* espace entre les boutons */
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
    padding: 6px 12px;
    border-radius: 4px;
    cursor: pointer;
}

.btn-approve:hover {
    background-color: #218838;
}

.btn-reject:hover {
    background-color: #c82333;
}

</style>

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
                                        <td>{{ $reservation->client->name }} </td>
                                        <td>{{ $reservation->client->email }} </td>
                                        <td>{{ $reservation->reservation_tele }} </td>
                                        <td>{{ $reservation->reservation_date }} </td>
                                        <td>{{ $reservation->reservation_time }}</td>
                                        <td class="reservation-actions">
                                            <form action="{{ route('restaurant.reservation.approve', $reservation->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-approve">Approuver</button>
                                            </form>
                                            <form action="{{ route('restaurant.reservation.reject', $reservation->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn-reject">Rejeter</button>
                                            </form>
                                        </td>
                                    </tr>
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