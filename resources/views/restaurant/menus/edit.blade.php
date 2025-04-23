@extends('restaurant.master')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

<style>
.plat-box {
    position: relative;
    margin-bottom: 1rem; /* Espace entre chaque plat */
}

.delete-plat {
    position: absolute;
    top: 0.5rem; /* Descend un peu le bouton */
    right: 0.5rem; /* Ramène le bouton plus à gauche */
    background-color: #f87171; /* Rouge vif */
    color: #ffffff;
    border: none;
    padding: 0.5rem;
    border-radius: 10%; /* Bords ronds */
    font-size: 1.2rem;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.2s ease;
    z-index: 10; /* Assure que le bouton est au-dessus des autres éléments */
    display: inline-block; /* Force l'affichage du bouton */
}

.delete-plat:hover {
    background-color: #dc2626;
    transform: scale(1.1);
}

.form-section {
    position: relative;
}

</style>

<title>Resto- Modifier Menu</title>
<div class="container mx-auto p-6">
    <div class="menu-form-wrapper bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold mb-6 text-center">Modifier le Menu : {{ $menu->nom }}</h2>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('restaurant.menus.update', $menu) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-section">
                <label class="block text-gray-700 font-semibold mb-2">Nom du Menu</label>
                <input type="text" name="nom" value="{{ old('nom', $menu->nom) }}" class="w-full border rounded p-2"
                    required>
            </div>

            <h3 class="text-xl font-semibold mb-4">Plats associés</h3>

            @foreach($menu->plats as $index => $plat)
                <div class="form-section border p-4 rounded shadow bg-gray-50">
                    <input type="hidden" name="plats[{{ $index }}][id]" value="{{ $plat->id }}">

                    <div class="mb-2">
                        <label class="block">Nom du Plat</label>
                        <input type="text" name="plats[{{ $index }}][nom]" value="{{ $plat->nom }}"
                            class="w-full border p-2 rounded" required>
                    </div>

                    <div class="mb-2">
                        <label class="block">Prix</label>
                        <input type="number" name="plats[{{ $index }}][prix]" value="{{ $plat->prix }}"
                            class="w-full border p-2 rounded" step="0.01" required>
                    </div>

                    <div class="mb-2">
                        <label class="block">Photo actuelle</label>
                        @if($plat->photo)
                            <img src="{{ asset('storage/' . $plat->photo) }}" class="w-24 h-24 object-cover rounded mb-2">
                        @endif
                        <input type="file" name="plats[{{ $index }}][photo]">
                    </div>
                </div>
            @endforeach

            <div class="form-section">
                <h4 class="text-lg font-semibold mb-2">Ajouter un ou plusieurs nouveaux plats</h4>

                <div id="plats-container"></div>

                <div class="mt-4 text-right">
                    <button type="button" id="add-plat" class="btn-menu bg-green-600 hover:bg-green-700">+ Ajouter un
                        plat</button>
                </div>
            </div>

            <div class="text-center">
                <button type="submit" class="btn-menu">Mettre à jour le menu</button>
            </div>
        </form>
    </div>
</div>

<script>
    let platIndex = 0;

    document.addEventListener('DOMContentLoaded', function () {
        const addPlatButton = document.getElementById('add-plat');
        const platsContainer = document.getElementById('plats-container');

        addPlatButton.addEventListener('click', function () {
            const platBox = document.createElement('div');
            platBox.classList.add('form-section', 'border', 'p-4', 'mb-4', 'rounded', 'bg-gray-50', 'relative');
            platBox.innerHTML = `
                <button type="button" class="absolute top-2 right-2 text-red-600 hover:text-red-800 delete-plat text-sm">✖</button>
                <div class="mb-2">
                    <label class="block">Nom du nouveau plat</label>
                    <input type="text" name="new_plats[${platIndex}][nom]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-2">
                    <label class="block">Prix</label>
                    <input type="number" step="0.01" name="new_plats[${platIndex}][prix]" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-2">
                    <label class="block">Photo</label>
                    <input type="file" name="new_plats[${platIndex}][photo]" accept="image/*" class="w-full">
                </div>
            `;

            platsContainer.appendChild(platBox);
            platIndex++;
        });

        // Délégation pour supprimer un formulaire de plat
        document.getElementById('plats-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('delete-plat')) {
                e.target.closest('.form-section').remove();
            }
        });
    });
</script>
