@extends('restaurant.master')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

<div class="container mx-auto p-6 text-center">
    <h2 class="menu-title">Menus</h2>

    <div class="flex justify-center mb-4">
        <form action="{{ route('restaurant.menus.create') }}" method="GET">
            <button type="submit" class="btn-menu">
                Ajouter un menu
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif

    @if($menus->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($menus as $menu)
                <div class="bg-white shadow rounded-lg p-4 text-center">
                    <h3 class="text-lg font-bold">{{ $menu->nom }}</h3>
                    <p class="text-sm text-gray-600 mb-2">Nombre de plats : {{ $menu->plats->count() }}</p>

                    <ul class="text-sm">
                        @foreach($menu->plats as $plat)
                            <li class="mb-1 text-center">
                                <strong>{{ $plat->nom }}</strong> - {{ $plat->prix }}
                                @if($plat->photo)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $plat->photo) }}" alt="{{ $plat->nom }} "
                                            class="w-32 h-32 object-cover rounded-lg mx-auto">
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-4 flex justify-center space-x-2">
                        <!-- Bouton Modifier -->
                        <form action="{{ route('restaurant.menus.edit', $menu) }}" method="GET">
                            <button type="submit" class="btn-menu bg-blue-600 hover:bg-blue-700">
                                Modifier
                            </button>
                        </form>

                        <!-- Bouton Supprimer -->
                        <form action="{{ route('restaurant.menus.destroy', $menu) }}" method="POST"
                            onsubmit="return confirm('Supprimer ce menu ?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn-delete">Supprimer</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center">Aucun menu enregistré.</p>
    @endif
</div>
