@extends('restaurant.master')
@section('restaurant')
    <div class="content-wrapper">
        <div class="form-container">
            <!-- En-tête avec effet dégradé -->
            <div class="header-banner">
                <div class="header-content">
                    <h1 class="profile-title">Créer un Menu</h1>

                    <!-- Fil d'ariane amélioré -->
                    <div class="breadcrumb-modern">
                        <a href="{{ route('restaurant.dashboard') }}" class="breadcrumb-item">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <a href="{{ route('restaurant.menus.index') }}" class="breadcrumb-item">
                            <i class="fas fa-list"></i> Menus
                        </a>
                        <i class="fas fa-chevron-right breadcrumb-separator"></i>
                        <span class="breadcrumb-item active">Créer</span>
                    </div>
                </div>
            </div>

            <!-- Formulaire de création de menu -->
            <div class="form-card">
                <div class="form-header">
                    <div class="form-icon-container">
                        <div class="form-icon-circle">
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                    <h2 class="form-subtitle">Nouveau Menu</h2>
                    <p class="form-description">Ajoutez un nouveau menu avec ses plats</p>
                </div>

                <div class="form-divider"></div>

                <!-- Affichage des erreurs de validation -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('restaurant.menus.store') }}" method="POST" enctype="multipart/form-data"
                    class="menu-form" id="menuForm">
                    @csrf

                    <!-- Nom du menu -->
                    <div class="form-group">
                        <label for="nom" class="form-label">
                            <i class="fas fa-tag form-icon"></i> Nom du menu
                        </label>
                        <input type="text" name="nom" id="nom" required class="form-control"
                            placeholder="Ex: Menu du jour, Menu découverte..." value="{{ old('nom') }}">
                        @error('nom')
                            <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Séparateur -->
                    <div class="section-divider">
                        <span class="divider-text">Plats du menu</span>
                    </div>

                    <!-- Plats -->
                    <div id="plats-container" class="plats-container">
                        <!-- Plat #1 (initial) -->
                        <div class="plat-box">
                            <div class="plat-header">
                                <span class="plat-number">Plat #1</span>
                            </div>

                            <div class="plat-content">
                                <div class="plat-form-grid">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-hamburger form-icon"></i> Nom du plat
                                        </label>
                                        <input type="text" name="plats[0][nom]" required class="form-control"
                                            placeholder="Ex: Burger Maison" value="{{ old('plats.0.nom') }}">
                                        @error('plats.0.nom')
                                            <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-money-bill-wave form-icon"></i> Prix
                                        </label>
                                        <div class="input-with-icon">
                                            <input type="number" step="0.01" name="plats[0][prix]" required
                                                class="form-control" placeholder="Ex: 12.99" value="{{ old('plats.0.prix') }}">
                                            <div class="input-icon-right">
                                                <i class="fas fa-coins"></i>
                                            </div>
                                            @error('plats.0.prix')
                                                <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-image form-icon"></i> Photo
                                    </label>
                                    <div class="file-input-container">
                                        <input type="file" name="plats[0][photo]" id="photo-0" accept="image/*"
                                            class="file-input">
                                        <label for="photo-0" class="file-input-label">
                                            <i class="fas fa-upload"></i>
                                            <span class="file-input-text">Choisir une image</span>
                                        </label>
                                        <div class="file-preview" id="preview-0">
                                            <img src="" alt="" class="preview-image hidden">
                                            <span class="preview-placeholder">Aperçu</span>
                                        </div>
                                        @error('plats.0.photo')
                                            <p class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ajouter un plat -->
                    <div class="add-plat-container">
                        <button type="button" id="add-plat" class="btn-add-plat">
                            <i class="fas fa-plus-circle"></i> Ajouter un plat
                        </button>
                    </div>

                    <div class="form-divider"></div>

                    <!-- Bouton soumettre -->
                    <div class="form-action">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Enregistrer le menu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Variables pour les couleurs */
        :root {
            --primary-color: #10b981;
            --primary-dark: #065f46;
            --primary-light: #d1fae5;
            --primary-hover: #059669;
            --text-dark: #064e3b;
            --text-light: #f0fdfa;
            --border-color: #99f6e4;
            --background-light: #f8fffc;
            --shadow-color: rgba(16, 185, 129, 0.15);
            --delete-btn: #ef4444;
            --delete-hover: #dc2626;
        }

        /* Styles généraux */
        .content-wrapper {
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .form-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Style de l'en-tête avec dégradé */
        .header-banner {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px var(--shadow-color);
            position: relative;
            overflow: hidden;
        }

        .header-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.2) 0%, transparent 60%);
            transform: rotate(-30deg);
        }

        .header-content {
            position: relative;
            z-index: 1;
        }

        .profile-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Fil d'ariane amélioré */
        .breadcrumb-modern {
            display: flex;
            align-items: center;
            color: white;
            font-size: 1rem;
        }

        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .breadcrumb-item:hover {
            color: white;
            text-decoration: none;
        }

        .breadcrumb-item.active {
            font-weight: 600;
            color: white;
        }

        .breadcrumb-separator {
            margin: 0 12px;
            font-size: 0.8rem;
            opacity: 0.8;
        }

        /* Carte du formulaire */
        .form-card {
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 8px 20px var(--shadow-color);
            padding: 30px;
            margin-bottom: 30px;
        }

        .form-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-icon-container {
            margin-bottom: 15px;
        }

        .form-icon-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px var(--shadow-color);
        }

        .form-icon-circle i {
            font-size: 2rem;
            color: white;
        }

        .form-subtitle {
            font-size: 1.6rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .form-description {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .form-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            margin: 15px 0 30px;
        }

        /* Formulaire */
        .menu-form {
            padding: 10px 0;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: var(--text-dark);
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .form-icon {
            color: var(--primary-color);
            margin-right: 5px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--background-light);
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
            outline: none;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-control {
            padding-right: 40px;
        }

        .input-icon-right {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
        }

        .error-message {
            color: #ef4444;
            font-size: 0.85rem;
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Alert styling */
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #b91c1c;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        /* Section Divider */
        .section-divider {
            position: relative;
            text-align: center;
            margin: 30px 0;
        }

        .section-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--primary-light), transparent);
            z-index: 0;
        }

        .divider-text {
            background-color: white;
            padding: 0 15px;
            position: relative;
            z-index: 1;
            color: var(--primary-dark);
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Plats */
        .plats-container {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .plat-box {
            border: 1px solid var(--primary-light);
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            transition: box-shadow 0.3s ease;
        }

        .plat-box:hover {
            box-shadow: 0 5px 15px var(--shadow-color);
        }

        .plat-header {
            background-color: var(--primary-light);
            padding: 12px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .plat-number {
            font-weight: 600;
            color: var(--primary-dark);
        }

        .delete-plat {
            background-color: var(--delete-btn);
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 0.9rem;
        }

        .delete-plat:hover {
            background-color: var(--delete-hover);
            transform: scale(1.1);
        }

        .plat-content {
            padding: 20px;
            background-color: white;
        }

        .plat-form-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        @media (max-width: 768px) {
            .plat-form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }

        /* Input file personnalisé */
        .file-input-container {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .file-input {
            display: none;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: var(--primary-color);
            color: white;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 0 0 auto;
            font-size: 0.9rem;
        }

        .file-input-label:hover {
            background-color: var(--primary-dark);
        }

        .file-preview {
            width: 120px;
            height: 80px;
            border: 1px dashed var(--primary-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: var(--background-light);
        }

        .preview-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .preview-placeholder {
            color: #9ca3af;
            font-size: 0.9rem;
        }

        .hidden {
            display: none;
        }

        /* Bouton d'ajout de plat */
        .add-plat-container {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }

        .btn-add-plat {
            background-color: white;
            color: var(--primary-color);
            border: 2px dashed var(--primary-color);
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-add-plat:hover {
            background-color: var(--primary-light);
            color: var(--primary-dark);
            border-style: solid;
        }

        /* Bouton de sauvegarde */
        .form-action {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .btn-save {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 10px var(--shadow-color);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px var(--shadow-color);
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-dark) 100%);
        }
    </style>

<script>
    // Fonction pour mettre à jour l'aperçu de l'image
function previewImage(input, previewId) {
    const file = input.files[0];
    const previewContainer = document.getElementById(previewId);
    const img = previewContainer.querySelector('.preview-image');
    const placeholder = previewContainer.querySelector('.preview-placeholder');

    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            img.src = e.target.result;
            img.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        img.src = '';
        img.classList.add('hidden');
        placeholder.classList.remove('hidden');
    }
}

// Activer l'aperçu pour le premier plat (index 0)
document.getElementById('photo-0').addEventListener('change', function () {
    previewImage(this, 'preview-0');
});

let platIndex = 1;

// Fonction pour mettre à jour les indices des champs de formulaire
function updatePlatIndices() {
    const platBoxes = document.querySelectorAll('.plat-box');
    
    platBoxes.forEach((box, index) => {
        // Mettre à jour le numéro affiché
        const platNumber = box.querySelector('.plat-number');
        if (platNumber) {
            platNumber.textContent = `Plat #${index + 1}`;
        }
        
        // Mettre à jour les noms des champs pour l'envoi du formulaire
        const inputs = box.querySelectorAll('input[name*="plats["]');
        inputs.forEach(input => {
            const inputName = input.name;
            const fieldType = inputName.match(/\]\[(.*?)\]$/)[1]; // Extraire nom, prix ou photo
            input.name = `plats[${index}][${fieldType}]`;
            
            // Mettre à jour l'ID pour les champs de type file
            if (fieldType === 'photo') {
                const oldId = input.id;
                const newId = `photo-${index}`;
                input.id = newId;
                
                // Mettre à jour aussi l'attribut "for" du label associé
                const label = box.querySelector(`label[for="${oldId}"]`);
                if (label) {
                    label.setAttribute('for', newId);
                }
                
                // Mettre à jour l'ID du conteneur d'aperçu
                const previewContainer = box.querySelector('.file-preview');
                if (previewContainer) {
                    previewContainer.id = `preview-${index}`;
                }
            }
        });
    });
}

// Ajouter un nouveau plat
document.getElementById('add-plat').addEventListener('click', function () {
    const container = document.getElementById('plats-container');
    const currentIndex = platIndex;

    const newPlat = document.createElement('div');
    newPlat.classList.add('plat-box');
    newPlat.innerHTML = `
        <div class="plat-header">
            <span class="plat-number">Plat #${currentIndex + 1}</span>
            <button type="button" class="delete-plat" title="Supprimer ce plat">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="plat-content">
            <div class="plat-form-grid">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-hamburger form-icon"></i> Nom du plat
                    </label>
                    <input type="text" name="plats[${currentIndex}][nom]" required class="form-control"
                        placeholder="Ex: Burger Maison">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-money-bill-wave form-icon"></i> Prix
                    </label>
                    <div class="input-with-icon">
                        <input type="number" step="0.01" name="plats[${currentIndex}][prix]" required
                            class="form-control" placeholder="Ex: 12.99">
                        <div class="input-icon-right">
                            <i class="fas fa-coins"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-image form-icon"></i> Photo
                </label>
                <div class="file-input-container">
                    <input type="file" name="plats[${currentIndex}][photo]" id="photo-${currentIndex}" accept="image/*"
                        class="file-input">
                    <label for="photo-${currentIndex}" class="file-input-label">
                        <i class="fas fa-upload"></i>
                        <span class="file-input-text">Choisir une image</span>
                    </label>
                    <div class="file-preview" id="preview-${currentIndex}">
                        <img src="" alt="" class="preview-image hidden">
                        <span class="preview-placeholder">Aperçu</span>
                    </div>
                </div>
            </div>
        </div>
    `;

    container.appendChild(newPlat);

    // Activer l'aperçu de l'image pour ce plat
    document.getElementById(`photo-${currentIndex}`).addEventListener('change', function () {
        previewImage(this, `preview-${currentIndex}`);
    });

    // Attacher l'écouteur d'événement de suppression
    newPlat.querySelector('.delete-plat').addEventListener('click', function () {
        container.removeChild(newPlat);
        updatePlatIndices(); // Mettre à jour les indices après suppression
    });

    platIndex++;
});

// Vérifier le formulaire avant soumission
document.querySelector('.menu-form').addEventListener('submit', function(e) {
    // Consigner les données du formulaire pour le débogage
    console.log('Soumission du formulaire...');
    
    // Vérifier que le formulaire a au moins un plat
    const plats = document.querySelectorAll('.plat-box');
    if (plats.length === 0) {
        e.preventDefault();
        alert('Vous devez ajouter au moins un plat au menu');
        return false;
    }
    
    // IMPORTANT: Assurer que les indices sont séquentiels avant l'envoi
    updatePlatIndices();
    
    console.log('Formulaire validé');
    return true;
});

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Ajouter le bouton de suppression pour le premier plat s'il n'existe pas déjà
    const firstPlat = document.querySelector('.plat-box');
    if (firstPlat && !firstPlat.querySelector('.delete-plat')) {
        const header = firstPlat.querySelector('.plat-header');
        if (header) {
            const deleteButton = document.createElement('button');
            deleteButton.type = 'button';
            deleteButton.className = 'delete-plat';
            deleteButton.title = 'Supprimer ce plat';
            deleteButton.innerHTML = '<i class="fas fa-times"></i>';
            deleteButton.addEventListener('click', function() {
                if (document.querySelectorAll('.plat-box').length > 1) {
                    firstPlat.remove();
                    updatePlatIndices();
                } else {
                    alert('Vous devez avoir au moins un plat dans le menu');
                }
            });
            header.appendChild(deleteButton);
        }
    }
});
</script>
@endsection