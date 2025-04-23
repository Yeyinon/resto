@extends('client.master')

@section('client')
<title>Resto - Menu</title>
    <div class="container">
        <h1>Menu du restaurant {{ $restaurant->name }}</h1>

        @foreach ($menus as $menu)
            <div class="card mb-4">
                <div class="card-header">
                    <h2>{{ $menu->nom }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($menu->plats as $plat)
                            <div class="col-md-4">
                                <div class="card mb-3">
                                    <img src="{{ asset('storage/' . $plat->photo) }}" class="card-img-top" alt="{{ $plat->nom }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $plat->nom }}</h5>
                                        <p class="card-text">{{ $plat->description }}</p>
                                        <p class="card-text"><strong>Prix: </strong>XOF{{ $plat->prix }}</p>

                                        <form action="{{ route('client.cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                            <input type="number" name="quantity" value="1" min="1" class="form-control"
                                                style="width: 70px; display: inline-block;">
                                            <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                                        </form>


                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Aucun plat disponible pour ce menu.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endforeach

        <div class="text-center my-4">
            <a href="{{ route('client.cart.show') }}" class="btn btn-success">Voir mon panier</a>
        </div>
    </div>
@endsection