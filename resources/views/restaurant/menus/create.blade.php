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
}

.delete-plat:hover {
    background-color: #dc2626;
    transform: scale(1.1);
}

</style>

<title>Resto- Créer Menu</title>
<div class="form-wrapper">
    <div class="form-container">
        <h2 class="form-title">Créer un nouveau menu</h2>

        <form action="{{ route('restaurant.menus.store') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf

            <!-- Nom du menu -->
            <div class="field-group">
                <label for="nom" class="field-label">Nom du menu</label>
                <input type="text" name="nom" id="nom" required class="field-input">
                @error('nom') <p class="error-message">{{ $message }}</p> @enderror
            </div>

            <!-- Plats -->
            <div id="plats-container" class="space-between">
                <!-- Plat #1 -->
                <div class="plat-box">
                    <div class="field-group">
                        <label class="field-label">Nom du plat</label>
                        <input type="text" name="plats[0][nom]" required class="field-input">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Prix</label>
                        <input type="number" step="0.01" name="plats[0][prix]" required class="field-input">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Photo</label>
                        <input type="file" name="plats[0][photo]" accept="image/*" class="field-input">
                    </div>
                </div>
            </div>

            <!-- Ajouter un plat -->
            <div class="text-center">
                <button type="button" id="add-plat" class="btn-secondary">+ Ajouter un plat</button>
            </div>

            <!-- Soumettre -->
            <div class="text-center">
                <button type="submit" class="btn-primary">💾 Enregistrer le menu</button>
            </div>
        </form>
    </div>
</div>
<script>
    let platIndex = 1;

    document.getElementById('add-plat').addEventListener('click', function () {
        const container = document.getElementById('plats-container');

        const html = `
            <div class="plat-box relative">
                <button type="button" class="delete-plat absolute top-0 right-0 p-1 bg-red-500 text-white rounded-full font-bold" onclick="removePlat(this)">✖</button>
                <div class="field-group">
                    <label class="field-label">Nom du plat</label>
                    <input type="text" name="plats[${platIndex}][nom]" required class="field-input">
                </div>
                <div class="field-group">
                    <label class="field-label">Prix</label>
                    <input type="number" step="0.01" name="plats[${platIndex}][prix]" required class="field-input">
                </div>
                <div class="field-group">
                    <label class="field-label">Photo</label>
                    <input type="file" name="plats[${platIndex}][photo]" accept="image/*" class="field-input">
                </div>
            </div>
        `;

        container.insertAdjacentHTML('beforeend', html);
        platIndex++;
    });

    // Fonction pour supprimer un plat
    function removePlat(button) {
        const platBox = button.closest('.plat-box');
        platBox.remove();
    }
</script>
