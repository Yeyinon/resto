@extends('master')
@section('guest')
    <title>Resto - Découvrez les restaurants</title>
    <main>
        <div class="hero_single version_4">
            <div class="opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.6)">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-xl-9 col-lg-10 col-md-8">
                            <h1>Liste des restaurants</h1>
                            <p>Nous avons sélectionné pour vous les restaurants qui vous conviennent</p>
                            <form method="GET" action="{{ route('search') }}">
                                <div class="row g-0 custom-search-input">
                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <input class="form-control" type="text" name="query"
                                                placeholder="Que recherchez vous ?...">
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


                        </div>
                    </div>
                    <!-- /row -->
                </div>
            </div>
        </div>
        <div class="page_header element_to_stick">
            <div class="container">
                <div class="row">
                    <div class="col-xl-8 col-lg-7 col-md-7 d-none d-md-block">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="{{ route('view_all') }}">View restaurant</a></li>

                            </ul>
                        </div>
                        <h1>{{ $nbr_resto }} restaurants existent en ce moment</h1>
                    </div>
                </div>
                <!-- /row -->
            </div>
        </div>
        <!-- /page_header -->

        <div class="filters_full clearfix add_bottom_15">
            <div class="container">
                <div class="switch-field">
                    <input type="radio" id="all" name="listing_filter" value="all" checked data-filter="*" class="selected">
                    <label for="all">All</label>
                    <input type="radio" id="popular" name="listing_filter" value="popular" data-filter=".popular">
                    <label for="popular">Popular</label>
                    <input type="radio" id="latest" name="listing_filter" value="latest" data-filter=".latest">
                    <label for="latest">Latest</label>
                </div>
            </div>
        </div>
        <!-- /filters_full -->

        <div class="container my-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach ($restaurants as $restaurant)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            @if($restaurant->image_path)
                                <img src="{{ asset($restaurant->image_path) }}" class="card-img-top" alt="{{ $restaurant->name }}">
                            @else
                                <img src="{{ asset('assets-home/img/detail_3.jpg') }}" class="card-img-top"
                                    alt="{{ $restaurant->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $restaurant->name }}</h5>
                                <p class="card-text text-muted">{{ $restaurant->location }}</p>
                                @if($restaurant->yums > 0)
                                    <span class="badge text-warning border border-warning bg-transparent">
                                        +{{ $restaurant->yums }} Yums
                                    </span>
                                @endif
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="{{ url('client/book/' . $restaurant->id) }}" class="btn btn-outline-success w-100">
                                    Réservez ici
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- /row -->

        <!-- /container -->

    </main>


    <!-- SPECIFIC SCRIPTS -->
    <script src="{{ asset('asset-home/js/sticky_sidebar.min.js') }}"></script>
    <script src="{{ asset('asset-home/js/specific_listing.js') }}"></script>
    <script src="{{ asset('asset-home/js/isotope.min.js') }}"></script>
    <script>
        $(window).on("load", function () {
            var $container = $('.isotope-wrapper');
            $container.isotope({
                itemSelector: '.isotope-item',
                layoutMode: 'masonry'
            });
        });
        $('.switch-field').on('click', 'input', 'change', function () {
            var selector = $(this).attr('data-filter');
            $('.isotope-wrapper').isotope({
                filter: selector
            });
        });
    </script>

    <!-- Map LeafLet + Mapbox-->
    <script src="{{ asset('asset-home/js/leaflet_map/leaflet.min.js') }}"></script>
    <script src="{{ asset('asset-home/js/leaflet_map/leaflet_markercluster.min.js') }}"></script>
    <script src="{{ asset('asset-home/js/leaflet_map/leaflet_markers.js') }}"></script>
    <script src="{{ asset('asset-home/js/leaflet_map/leaflet_func.js') }}"></script>
    <!-- /main -->
@endsection