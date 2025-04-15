@extends('restaurant.master')
<link rel="stylesheet" href="{{ asset('css/style.min.css') }}">

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
            <div class="plat-box">
                <div class="field-group">
                    <label class="field-label">Nom du plat</label>
                    <input type="text" name="plats[${platIndex}][nom]" required class="field-input">
                </div>
                <div class="field-group">
                    <label class="field-label">Prix (€)</label>
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
</script>
