@extends('client.master')

@section('client')
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

        <div class="text-end">
            <h3>Total général : {{ $total }} XOF</h3>
            <a href="{{ route('client.cart.checkout') }}" class="btn btn-success mt-3">Passer à la commande</a>
        </div>
    @else
        <div class="alert alert-info">
            Votre panier est vide.
        </div>
    @endif
</div>
@endsection
