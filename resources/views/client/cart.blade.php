@extends('client.master')

@section('client')
<title>Resto - Mon Panier</title>
<div class="container py-4">
    <h1 class="mb-4">🛒 Mon panier</h1>

    @if(count($cart) > 0)
        @foreach ($cart as $menu)
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">{{ $menu['nom'] }}</h4>
                </div>
                <div class="card-body">
                    <p><strong>Quantité :</strong> {{ $menu['quantité'] }}</p>

                    <ul class="list-group mb-3">
                        @foreach ($menu['plats'] as $plat)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $plat->nom }}
                                <span class="badge bg-secondary">{{ $plat->prix }} XOF</span>
                            </li>
                        @endforeach
                    </ul>

                    <p><strong>Sous-total :</strong> {{ $menu['prix'] }} XOF</p>
                </div>
            </div>
        @endforeach

        @php
            $serviceFee = $total * 0.1;
            $grandTotal = $total + $serviceFee;
        @endphp

        <div class="card shadow-sm">
            <div class="card-body">
                <h3>Total général : {{ number_format($total, 0, ',', ' ') }} XOF</h3>
                <ais de service (10%) : {{ number_format($serviceFee, 0, ',', ' ') }} XOF</p>
                <h4>Total à payer : {{ number_format($grandTotal, 0, ',', ' ') }} XOF</h4>

                <form action="{{ route('fedapay.pay') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-3">
                            <input type="text" name="firstname" class="form-control" placeholder="Prénom" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="lastname" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="col-md-3">
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="phone" class="form-control" placeholder="Téléphone (ex: 97000000)" required>
                        </div>
                    </div>

                    <input type="hidden" name="amount" value="{{ $grandTotal }}">

                    <button type="submit" class="btn btn-success">Payer avec FedaPay</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Votre panier est vide.
        </div>
    @endif
</div>
@endsection
