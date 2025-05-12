@extends('client.master')

@section('client')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        body {
            background-color: #f0fdf4;
            font-family: 'Poppins', sans-serif;
        }

        h1, h2, h5 {
            color: #065f46;
        }

        .menu-title {
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 2px solid #10b981;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .menu-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .menu-card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-bottom: 2px solid #d1fae5;
        }

        .menu-card .card-body {
            padding: 20px;
        }

        .menu-card h5 {
            font-weight: 600;
        }

        .price {
            color: #10b981;
            font-size: 1.1rem;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
        }

        .btn-add {
            background-color: #10b981;
            color: white;
            border: none;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .btn-add:hover {
            background-color: #0e9b72;
        }

        .btn-cart {
            background-color: #065f46;
            border-radius: 12px;
            padding: 12px 24px;
            font-size: 1.2rem;
            font-weight: 500;
            color: white;
            text-decoration: none;
        }

        .btn-cart:hover {
            background-color: #064e3b;
        }
    </style>

    <div class="container py-5">
        <h1 class="text-center menu-title mb-5">Menu du restaurant {{ $restaurant->name }}</h1>

        @foreach ($menus as $menu)
            <div class="mb-5">
                <h2 class="mb-4">{{ $menu->nom }}</h2>
                <div class="row">
                    @forelse ($menu->plats as $plat)
                        <div class="col-md-4 mb-4">
                            <div class="menu-card h-100">
                                <img src="{{ asset('storage/' . $plat->photo) }}" alt="{{ $plat->nom }}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="mb-1">{{ $plat->nom }}</h5>
                                    <p class="text-muted mb-2">{{ $plat->description }}</p>
                                    <p class="price mb-3">XOF {{ $plat->prix }}</p>
                                    <form action="{{ route('client.cart.add') }}" method="POST" class="mt-auto">
                                        @csrf
                                        <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                        <div class="d-flex align-items-center gap-2">
                                            <input type="number" name="quantity" value="1" min="1"
                                                class="form-control" style="width: 80px;">
                                            <button type="submit" class="btn btn-add">Ajouter +</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">Aucun plat pour ce menu.</p>
                    @endforelse
                </div>
            </div>
        @endforeach

        <div class="text-center mt-5">
            <a href="{{ route('client.cart.show') }}" class="btn-cart">🛒 Voir mon panier</a>
        </div>
    </div>
@endsection
