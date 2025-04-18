@extends('client.master')
@section('client')
    <title>Resto - Inscription client</title>
    <main class="bg_gray pattern">

        <div class="container margin_60_40">
            <div class="row justify-content-center">
                <div class="col-lg-4">
                    <div class="sign_up">
                        <div class="head">
                            <div class="title">
                                <h3>S'inscrire</h3>
                            </div>
                        </div>
                        <!-- /head -->
                        <div class="main">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="post" action="{{ route('client.register.create') }}">
                                @csrf
                                <h6>Détails personnels</h6>
                                <div class="form-group">
                                    <i class="icon_pencil"></i>
                                    <input class="form-control" placeholder="Nom *" name="name" type="text" required>
                                </div>
                                <div class="form-group">
                                    <i class="icon_mail"></i>
                                    <input class="form-control" placeholder="Email *" name="email" type="email" required>
                                </div>
                                <div class="form-group">
                                    <i class="icon_lock"></i>
                                    <input class="form-control" placeholder="Mot de passe *" name="password" type="password"
                                        required>
                                </div>
                                <div class="text-center dont-have">Vous avez déjà un compte ? <a
                                        href="{{ route('client_login_form') }}">Connexion</a></div><br>

                                <div class="form-group text-center"><input type="submit" class="btn_1" id="submit-register"
                                        value="S'inscrire maintenant"></div>
                        </div>
                        </form>
                    </div>
                    <!-- /box_booking -->
                </div>
                <!-- /col -->

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->

    </main>
@endsection