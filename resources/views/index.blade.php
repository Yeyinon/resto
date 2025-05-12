@vite('ressources/css/app.css')
@extends('master')

@section('guest')
	<title>Resto - Découvrez & Réservez</title>
	<!-- /header -->
	<main>
		<div class="hero_single version_2">
			<div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-xl-9 col-lg-10 col-md-8">
							<h1>Découvrez &amp; Réservez</h1>
							<p>le meilleur restaurant <span class="element" style="font-weight: 500"></span></p>
						</div>
					</div>
					<!-- /row -->
				</div>
			</div>
		</div>
		<form method="GET" action="{{ route('client_login_form') }}">
			@csrf
			<div class="row g-0 custom-search-input">
				<div class="col-lg-4">
					<div class="form-group">
						<input class="form-control" type="text" name="query" placeholder="Que recherchez vous ?...">
						<i class="icon_search"></i>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="form-group">
						<input class="form-control no_border_r" type="text" name="location"
							placeholder="Cuisine, nom de restaurant...">
						<i class="icon_pin_alt"></i>
					</div>
				</div>
				<div class="col-lg-2">
					<input type="submit" value="RECHERCHE">
				</div>
			</div>
		</form>
		<div class="container margin_60_40">
			<div class="main_title">
				<span><em></em></span>
				<h2>Restaurants populaires</h2>
				<a href="{{ route('view_all') }}">View All</a>
			</div>

			<div class="owl-carousel owl-theme carousel_4">
				@foreach ($restaurants as $restaurant)
					<div class="item">
						<div class="strip">
							<figure>
								@if($restaurant->yums > 0)
									<span class="ribbon off">+ {{ $restaurant->yums }} Yums</span>
								@endif

								@if($restaurant->image_path)
									<!-- Utiliser l'image téléchargée par le restaurant si disponible -->
									<img src="{{ asset($restaurant->image_path) }}" data-src="{{ asset($restaurant->image_path) }}"
										class="owl-lazy" alt="{{ $restaurant->name }}">
								@else
									<!-- Utiliser l'image par défaut si aucune image n'a été téléchargée -->
									<img src="{{ asset('assets-home/img/detail_3.jpg') }}"
										data-src="{{ asset('assets-home/img/home_section_1.jpg') }}" class="owl-lazy"
										alt="{{ $restaurant->name }}">
								@endif

								<a href="client/book/{{ $restaurant->id }}" class="strip_info">
									<small>{{ $restaurant->name }}</small>
									<div class="item_title">
										<h3>{{ $restaurant->name }}</h3>
										<small>{{ $restaurant->location }}</small>
									</div>
								</a>
							</figure>
							<ul>
								<li><a class="loc_open" href="client/book/{{ $restaurant->id }}">Réservez ici</a></li>
								<li></li>
							</ul>
						</div>
					</div>
				@endforeach
			</div>
			<!-- /carousel -->

			<div class="banner lazy" data-bg="url(assets-home/img/blog-1.jpg)">
				<div class="wrapper d-flex align-items-center opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.2)">
					<div>
						<small>Resto</small>
						<h3>Plus de 100 restaurants</h3>
						<p>Réservez une table facilement au meilleur prix</p>
					</div>
				</div>
				<!-- /wrapper -->
			</div>
			<!-- /banner -->
		</div>

		<div class="call_section lazy" data-bg="url(img/reservation-bg.jpg)">
			<div class="container clearfix">
				<div class="col-lg-5 col-md-6 float-end wow">
					<div class="box_1">
						<h3>Êtes-vous un propriétaire de restaurant?</h3>
						<p>Rejoignez-nous pour augmenter votre visibilité en ligne. Vous aurez accès à encore plus de
							clients qui souhaitent profiter de vos plats savoureux à la maison.</p>
						<a href="{{ route('restaurant.register') }}" class="btn_1">En savoir plus</a>
					</div>
				</div>
			</div>
		</div>
		<!--/call_section-->

	</main>
	<!-- /main -->
@endsection