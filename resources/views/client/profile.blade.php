@extends('master') {{-- Assurez-vous que c'est le bon layout pour le client --}}
@section('title', 'Mon Profil - Resto') {{-- Titre spécifique pour cette page --}}

@section('guest') {{-- Ou '@yield('guest')' si c'est votre section de contenu principale --}}
    <div class="main-content"> {{-- Utilise la classe de votre layout global --}}
        <div class="profile-container container-custom"> {{-- Utilisez container-custom pour la largeur --}}
            <div class="page-title-section"> {{-- Utilisez la classe de votre header global pour les pages --}}
            </div>

            <div class="content-card profile-card"> {{-- Utilisez content-card pour la base du design --}}
                <div class="profile-header">
                    <div class="profile-icon-container">
                        <div class="profile-icon-circle">
                            <i class="fas fa-user"></i>
                        </div>
                    </div>
                    <h2 class="profile-subtitle">Gérez vos informations personnelles</h2>
                    <p class="profile-description">Mettez à jour votre nom, votre email et vos préférences.</p>
                </div>

                <div class="profile-divider"></div>
                
                {{-- Affichage des messages de succès/erreur --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('client.profile.update') }}" class="profile-form">
                    @csrf
                    {{-- Assurez-vous que $client est passé depuis le contrôleur, ou utilisez Auth::guard('client')->user() --}}
                    <input type="hidden" name="id" value="{{ $client->id }}"> 
                    
                    <div class="form-grid"> {{-- Utilise la grille pour la disposition horizontale --}}
                        <div class="form-group">
                            <label for="name">
                                <i class="fas fa-signature form-icon"></i> Nom
                            </label>
                            <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $client->name) }}">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="email">
                                <i class="fas fa-envelope form-icon"></i> Email
                            </label>
                            <input type="email" id="email" class="form-control" name="email" value="{{ old('email', $client->email) }}">
                             @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="form-grid"> {{-- Nouvelle grille pour les champs supplémentaires --}}
                        <div class="form-group">
                            <label for="phone">
                                <i class="fas fa-phone-alt form-icon"></i> Téléphone
                            </label>
                            <input type="text" id="phone" class="form-control" name="phone" value="{{ old('phone', $client->phone) }}">
                            @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">
                                <i class="fas fa-map-marker-alt form-icon"></i> Adresse
                            </label>
                            <input type="text" id="address" class="form-control" name="address" value="{{ old('address', $client->address) }}">
                            @error('address')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Section pour le changement de mot de passe (optionnel, peut être une page séparée) --}}
                    <div class="profile-divider"></div>
                    <h3 class="profile-subtitle text-center mt-4">Changer votre mot de passe</h3>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="current_password">
                                <i class="fas fa-lock form-icon"></i> Mot de passe actuel
                            </label>
                            <input type="password" id="current_password" class="form-control" name="current_password">
                            @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">
                                <i class="fas fa-unlock-alt form-icon"></i> Nouveau mot de passe
                            </label>
                            <input type="password" id="new_password" class="form-control" name="new_password">
                            @error('new_password')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password_confirmation">
                                <i class="fas fa-check-circle form-icon"></i> Confirmer le nouveau mot de passe
                            </label>
                            <input type="password" id="new_password_confirmation" class="form-control" name="new_password_confirmation">
                        </div>
                    </div>

                    <div class="form-action">
                        <button type="submit" class="btn-primary-custom"> {{-- Utilise votre bouton personnalisé --}}
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Les styles du profil du restaurant sont déjà bien définis dans votre `master.blade.php` global.
     Si vous les avez dans un fichier `restaurant.master`, vous devrez les copier dans le `layouts.master`
     utilisé par le client, ou les importer via `@stack('styles')` et `@push('styles')`.
     Je vais supposer qu'ils sont déjà disponibles via le `master.blade.php` général ou une feuille de style commune.
--}}