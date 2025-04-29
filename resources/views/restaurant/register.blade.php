@extends('master')
@section('guest')
    <title>Resto - Attirez de nouveaux clients</title>

    <main>
        <div class="hero_single version_3">
            <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-9 col-lg-10 col-md-8">
                            <h1>Attirez de nouveaux clients</h1>
                            <p>Plus de réservations de restaurants du coin</p>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
            </div>
        </div>
        <!-- /hero_single -->
        <div class="bg_gray">
            <div class="container margin_60_40">
                <div class="main_title center">
                    <span><em></em></span>
                    <h2>Pourquoi soumettre à Resto</h2>
                    <p>Que les saveurs authentiques ravivent vos plus beaux souvenirs.</p>
                </div>

                <div class="row justify-content-center align-items-center add_bottom_15">
                    <div class="col-lg-5">
                        <div class="box_about">
                            <h3>Boostez vos réservations</h3>
                            <p class="lead"></p>
                            <p> Resto est un service en ligne qui aide les restaurants à augmenter le nombre de réservations
                                en
                                ligne. En utilisant notre plateforme, les restaurants peuvent créer un profil en ligne pour
                                leur entreprise, ajouter des photos, des menus et des informations sur leurs horaires
                                d'ouverture et leurs emplacements. Les clients peuvent ensuite effectuer des réservations
                                directement depuis le site web du restaurant, ce qui facilite le processus de réservation
                                pour eux.</p>
                            <img src="{{ asset('assets-home/img/arrow_about.png') }}" alt="" class="arrow_1">
                        </div>
                    </div>
                    <div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
                        <img src="{{ asset('assets-home/img/about_1.svg') }}" alt="" class="img-fluid" width="250"
                            height="250">
                    </div>
                </div>
                <!-- /row -->
                <div class="row justify-content-center align-items-center add_bottom_15">
                    <div class="col-lg-5 pr-lg-5 text-center d-none d-lg-block">
                        <img src="{{ asset('assets-home/img/about_2.svg') }}" alt="" class="img-fluid" width="250"
                            height="250">
                    </div>
                    <div class="col-lg-5">
                        <div class="box_about">
                            <h3>Gérer facilement</h3>
                            <p>Les propriétaires d'entreprise peuvent gagner du temps et
                                de l'efficacité en ayant tous les outils de gestion essentiels à portée de main. Cela peut
                                leur permettre de se concentrer sur la croissance de leur entreprise et de fournir un
                                meilleur service à leurs clients.</p>
                            <img src="{{ asset('assets-home/img/arrow_about.png') }}" alt="" class="arrow_2">
                        </div>
                    </div>
                </div>
                <!-- /row -->
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-5">
                        <div class="box_about">
                            <h3>Atteindre de nouveaux clients</h3>
                            <p>Les entreprises peuvent étendre leur portée et augmenter leur nombre de clients
                                potentiels. Cela peut aider à stimuler la croissance de l'entreprise et à améliorer sa
                                rentabilité.</p>
                        </div>

                    </div>
                    <div class="col-lg-5 pl-lg-5 text-center d-none d-lg-block">
                        <img src="{{ asset('assets-home/img/about_3.svg') }}" alt="" class="img-fluid" width="250"
                            height="250">
                    </div>
                </div>
                <!-- /row -->
            </div>
            <!-- /container -->
        </div>
        <!-- /bg_gray -->





        <div class="bg_gray pattern" id="submit">
            <div class="container margin_60_40">
                <div class="row justify-content-center">
                    <div class="col-lg-5">
                        <div class="text-center add_bottom_15">
                            <h4>Veuillez remplir le formulaire ci-dessous</h4>
                            <p>pour créer un compte Restaurant</p>
                        </div>
                        <div id="message-register"></div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="post" action="{{ route('restaurant.register.create') }}">
                            @csrf
                            <h6>Données personnelles</h6>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Nom du resto *" required
                                            name="name">
                                    </div>
                                </div>
                            </div>
                            <!-- /row -->
                            <div class="row add_bottom_15">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Emplacement du resto"
                                            name="location">
                                    </div>
                                </div>
                            </div>
                            <div class="row add_bottom_15">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Numéro de téléphone du resto(Mobile Money)"
                                            name="phone_number" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row add_bottom_15">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Description du resto"
                                            name="description">
                                    </div>
                                </div>
                            </div>
                            <!-- /row -->
                            <h6>Login et mot de passe</h6>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <input type="email" class="form-control" placeholder="Adresse e-mail *" required
                                            name="email">
                                    </div>
                                </div>
                            </div>

                            <!-- /row -->
                            <div class="row add_bottom_15">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control" placeholder="Mot de passe *"
                                            name="password" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="password" class="form-control"
                                            placeholder="Confirmez le mot de passe *" name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>
                            <!-- Checkbox pour la politique de confidentialité -->
                            <div class="form-group form-check mt-3">
                                <input type="checkbox" class="form-check-input" id="privacyCheck" name="privacy_agreed"
                                    required>
                                <label class="form-check-label" for="privacyCheck">
                                    Lu et approuvé la <a href="{{ route('confidentialite') }}" target="_blank"
                                        class="text-primary">clause de confidentialité</a>.
                                </label>
                            </div>
                            <div class="text-center dont-have">Vous avez déjà un compte ? <a
                                    href="{{ route('login_form') }}">Connexion</a></div><br>

                            <div class="form-group text-center"><input type="submit" class="btn_1" value="Submit"
                                    id="submit-register"></div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /container -->
        </div>
        <!-- /bg_gray -->

    </main>
    <!-- /main -->
@endsection