@extends('master')
@section('title', 'Resto - Attirez de nouveaux clients')
@section('guest')
    <main>    
        <!-- Advantages Section -->
        <div class="bg_gray py-5">
            <div class="container py-4">
                <div class="content-card text-center mb-5">
                    <span class="badge bg-success mb-3">POURQUOI NOUS CHOISIR</span>
                    <h2 class="h1 mb-4" style="color: var(--text-dark);">Pourquoi soumettre à Resto</h2>
                    <p class="lead mb-0" style="color: var(--primary-dark);">Que les saveurs authentiques ravivent vos plus beaux souvenirs.</p>
                </div>

                <!-- Feature 1 -->
                <div class="content-card mb-4">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6 px-lg-5">
                            <div class="feature-box">
                                <div class="feature-icon mb-4">
                                    <i class="fas fa-chart-line fa-3x" style="color: var(--primary-color);"></i>
                                </div>
                                <h3 style="color: var(--primary-dark);">Boostez vos réservations</h3>
                                <p class="text-muted">
                                    Resto est un service en ligne qui aide les restaurants à augmenter le nombre de réservations
                                    en ligne. En utilisant notre plateforme, les restaurants peuvent créer un profil en ligne pour
                                    leur entreprise, ajouter des photos, des menus et des informations sur leurs horaires
                                    d'ouverture et leurs emplacements. Les clients peuvent ensuite effectuer des réservations
                                    directement depuis le site web du restaurant, ce qui facilite le processus de réservation
                                    pour eux.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center d-none d-lg-block">
                            <img src="{{ asset('assets-home/img/about_1.svg') }}" alt="Augmenter les réservations" class="img-fluid" width="300" height="300">
                        </div>
                    </div>
                </div>
                
                <!-- Feature 2 -->
                <div class="content-card mb-4">
                    <div class="row justify-content-center align-items-center flex-row-reverse">
                        <div class="col-lg-6 px-lg-5">
                            <div class="feature-box">
                                <div class="feature-icon mb-4">
                                    <i class="fas fa-tasks fa-3x" style="color: var(--primary-color);"></i>
                                </div>
                                <h3 style="color: var(--primary-dark);">Gérer facilement</h3>
                                <p class="text-muted">
                                    Les propriétaires d'entreprise peuvent gagner du temps et
                                    de l'efficacité en ayant tous les outils de gestion essentiels à portée de main. Cela peut
                                    leur permettre de se concentrer sur la croissance de leur entreprise et de fournir un
                                    meilleur service à leurs clients.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center d-none d-lg-block">
                            <img src="{{ asset('assets-home/img/about_2.svg') }}" alt="Gestion facile" class="img-fluid" width="300" height="300">
                        </div>
                    </div>
                </div>
                
                <!-- Feature 3 -->
                <div class="content-card">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6 px-lg-5">
                            <div class="feature-box">
                                <div class="feature-icon mb-4">
                                    <i class="fas fa-users fa-3x" style="color: var(--primary-color);"></i>
                                </div>
                                <h3 style="color: var(--primary-dark);">Atteindre de nouveaux clients</h3>
                                <p class="text-muted">
                                    Les entreprises peuvent étendre leur portée et augmenter leur nombre de clients
                                    potentiels. Cela peut aider à stimuler la croissance de l'entreprise et à améliorer sa
                                    rentabilité.
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-5 text-center d-none d-lg-block">
                            <img src="{{ asset('assets-home/img/about_3.svg') }}" alt="Nouveaux clients" class="img-fluid" width="300" height="300">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Advantages Section -->

        <!-- Registration Form Section -->
        <div class="py-5" id="submit" style="background: linear-gradient(135deg, var(--primary-light) 0%, #f8fffc 100%);">
            <div class="container py-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="content-card">
                            <div class="text-center mb-4">
                                <h3 style="color: var(--primary-dark);">Créez votre compte restaurant</h3>
                                <p class="text-muted">Complétez le formulaire ci-dessous pour rejoindre notre réseau</p>
                            </div>
                            
                            @if ($errors->any())
                                <div class="alert alert-danger shadow-sm mb-4">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            
                            <form method="post" action="{{ route('restaurant.register.create') }}" enctype="multipart/form-data" class="form-modern">
                                @csrf
                                
                                <div class="form-section mb-4">
                                    <h5 class="section-title"><i class="fas fa-utensils me-2" style="color: var(--primary-color);"></i>Informations du restaurant</h5>
                                    
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nom du restaurant *</label>
                                        <input type="text" class="form-control" id="name" placeholder="Ex: Le Gourmet Français" required name="name">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="location" class="form-label">Adresse du restaurant</label>
                                        <input type="text" class="form-control" id="location" placeholder="Ex: 123 Rue de la Gastronomie, Paris" name="location">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="phone_number" class="form-label">Téléphone du restaurant (Mobile Money) *</label>
                                        <input type="text" class="form-control" id="phone_number" placeholder="Ex: +229 00 00 00 00" name="phone_number" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description du restaurant</label>
                                        <textarea class="form-control" id="description" rows="4" name="description" placeholder="Décrivez votre restaurant, sa cuisine, son ambiance..."></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="restaurant_image" class="form-label">Image du restaurant</label>
                                        <input type="file" class="form-control" id="restaurant_image" name="restaurant_image" accept="image/*">
                                        <div class="form-text mt-2">
                                            <i class="fas fa-info-circle me-1" style="color: var(--primary-color);"></i>
                                            Téléchargez une image attrayante de votre restaurant (format recommandé: JPG, PNG - max 2MB)
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-section">
                                    <h5 class="section-title"><i class="fas fa-lock me-2" style="color: var(--primary-color);"></i>Informations de connexion</h5>
                                    
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Adresse e-mail *</label>
                                        <input type="email" class="form-control" id="email" placeholder="Ex: contact@votrerestaurant.com" required name="email">
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Mot de passe *</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password" placeholder="Votre mot de passe" name="password" required>
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirmation *</label>
                                            <div class="input-group">
                                                <input type="password" class="form-control" id="password_confirmation" placeholder="Confirmez le mot de passe" name="password_confirmation" required>
                                                <span class="input-group-text toggle-password" style="cursor: pointer;">
                                                    <i class="fas fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-check mt-4 mb-4">
                                    <input type="checkbox" class="form-check-input" id="privacyCheck" name="privacy_agreed" required>
                                    <label class="form-check-label" for="privacyCheck">
                                        J'ai lu et j'accepte la <a href="{{ route('confidentialite') }}" target="_blank" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">clause de confidentialité</a>
                                    </label>
                                </div>
                                
                                <div class="text-center mb-4">
                                    <button type="submit" class="btn-primary-custom">
                                        <i class="fas fa-paper-plane me-2"></i>Créer mon compte restaurant
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <p class="mb-0">Vous avez déjà un compte ? <a href="{{ route('login_form') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Connexion</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Registration Form Section -->
    </main>
@endsection

@section('styles')
<style>
    /* Styles spécifiques pour la page d'inscription restaurant */
    .form-modern .form-control {
        border-radius: 8px;
        padding: 12px 15px;
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }
    
    .form-modern .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px var(--primary-light);
    }
    
    .form-section {
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }
    
    .form-section:last-of-type {
        border-bottom: none;
    }
    
    .section-title {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
    }
    
    .feature-box {
        padding: 1rem;
    }
    
    .feature-icon {
        display: inline-block;
        height: 70px;
        width: 70px;
        line-height: 70px;
        border-radius: 50%;
        background-color: var(--primary-light);
        text-align: center;
    }
    
    .form-check-input:checked {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }
    
    .badge.bg-success {
        background-color: var(--primary-color) !important;
        font-weight: normal;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        border-radius: 20px;
    }
    
    /* Animation légère pour les cards */
    .content-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px var(--shadow-color);
    }
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle password visibility
        $(".toggle-password").click(function() {
            $(this).find('i').toggleClass("fa-eye fa-eye-slash");
            var input = $(this).closest('.input-group').find('input');
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        
        // Animation on scroll
        $(window).scroll(function() {
            $('.content-card').each(function() {
                var bottom_of_object = $(this).offset().top + $(this).outerHeight();
                var bottom_of_window = $(window).scrollTop() + $(window).height();
                
                if (bottom_of_window > bottom_of_object - 100) {
                    $(this).addClass('animated');
                }
            });
        });
    });
</script>
@endsection