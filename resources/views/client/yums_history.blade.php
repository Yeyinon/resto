@extends('master') {{-- Assurez-vous que c'est le bon layout pour le client --}}
@section('title', 'Mes Yums - Resto') {{-- Titre spécifique pour cette page --}}

@section('guest') {{-- Ou '@yield('guest')' si c'est votre section de contenu principale --}}
    <div class="main-content">
        <div class="profile-container container-custom">
            <div class="page-title-section">
            </div>

            <div class="content-card profile-card">
                <div class="profile-header">
                    <div class="profile-icon-container">
                        <div class="profile-icon-circle">
                            <i class="fas fa-star"></i> {{-- Icône Yums --}}
                        </div>
                    </div>
                    <h2 class="profile-subtitle">Votre solde de Yums</h2>
                    <p class="profile-description">Utilisez vos Yums pour obtenir des réductions dans nos restaurants partenaires !</p>
                </div>

                <div class="profile-divider"></div>
                
                <div class="text-center mb-4">
                    <h3 class="display-4 font-weight-bold" style="color: var(--primary-color);">{{ $client->yums ?? 0 }} Yums</h3>
                    <p class="text-muted">Équivaut à une réduction de **{{ number_format(($client->yums ?? 0) / 100 * 1000, 0, ',', ' ') }} XOF**</p>
                    <small class="text-muted">(Basé sur 100 Yums = 1000 XOF de rabais)</small>
                </div>

                <div class="profile-divider"></div>

                <h3 class="profile-subtitle text-center mt-4 mb-3">Historique de vos transactions Yums</h3>
                
                @if ($yumsTransactions->isEmpty())
                    <p class="text-center text-muted">Vous n'avez pas encore de transactions Yums.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="bg-light">
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Quantité</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($yumsTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @if ($transaction->type == 'gain')
                                                <span class="badge bg-success text-white">Gain</span>
                                            @else
                                                <span class="badge bg-danger text-white">Utilisation</span>
                                            @endif
                                        </td>
                                        <td class="{{ $transaction->type == 'gain' ? 'text-success' : 'text-danger' }}">
                                            {{ $transaction->type == 'gain' ? '+' : '-' }}{{ $transaction->amount }} Yums
                                        </td>
                                        <td>{{ $transaction->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                <div class="profile-divider mt-4"></div>

                <h3 class="profile-subtitle text-center mt-4">Comment gagner et utiliser vos Yums ?</h3>
                <div class="row text-center mt-3">
                    <div class="col-md-6 mb-3">
                        <div class="p-3 border rounded h-100 d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-hand-holding-usd fa-2x mb-2" style="color: var(--primary-color);"></i>
                            <h5>Gagner des Yums</h5>
                            <ul class="list-unstyled text-left">
                                <li><i class="fas fa-check-circle text-success me-2"></i> Réservez et honorez vos réservations.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Profitez d'offres spéciales Yums sur certains restaurants.</li>
                                <li><i class="fas fa-check-circle text-success me-2"></i> Parrainez vos amis !</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="p-3 border rounded h-100 d-flex flex-column justify-content-center align-items-center">
                            <i class="fas fa-ticket-alt fa-2x mb-2" style="color: var(--primary-color);"></i>
                            <h5>Utiliser vos Yums</h5>
                            <p class="text-center">Échangez vos Yums lors de la réservation ou directement au restaurant (selon les conditions spécifiques).</p>
                            <p class="text-center text-primary">Consultez les restaurants participants pour les offres Yums !</p>
                            <a href="{{ route('view_all') }}" class="btn-primary-custom mt-2">
                                <i class="fas fa-utensils"></i> Trouver des restaurants Yums
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    {{-- Pour les tableaux, si vous utilisez DataTables ou similaire, ajoutez les scripts ici --}}
@endsection 