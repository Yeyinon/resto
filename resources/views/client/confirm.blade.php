@extends('client.master')
@section('client')
<title>Resto - Réservation Confirmée</title>
<main class="bg_gray pattern">

    <div class="container margin_60_40">
        <div class="row justify-content-center">
            <div class="col-lg-4">
                <div class="box_booking_2">
                    <div class="head">
                        <div class="title">
                        {{-- <h3>{{ $restaurant->id }}</h3> --}}
                        {{-- {{ $restaurant->location }} --}}
                        </div>
                    </div>
                    <!-- /head -->
                    <div class="main">
                        <div id="confirm">
                            <div class="icon icon--order-success svg add_bottom_15">
                                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
                                    <g fill="none" stroke="#8EC343" stroke-width="2">
                                        <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                                        <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                                    </g>
                                </svg>
                            </div>
                            <a href="/" class="home-icon"><i class="fas fa-arrow-circle-left"></i></a>
                            <h3>Réservation envoyée!</h3>
                            <p>votre réservation est en attente de confirmation </p>
                            <div class="text-center dont-have">
                                <a href="{{ route('client.reservations') }}">En savoir plus</a>
                            </div><br>
                            <div class="text-center">
                            <a href="{{ route('client.menu', ['restaurant_id' => $restaurant->id]) }}" class="btn_1 full-width">Commander</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /box_booking -->
            </div>
            <!-- /col -->
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->

</main>
<!-- /main -->
@endsection
