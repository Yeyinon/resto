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
                                                placeholder="What are you looking for...">
                                            <i class="icon_search"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <input class="form-control no_border_r" type="text" name="location"
                                                placeholder="Address, neighborhood...">
                                            <i class="icon_pin_alt"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <input type="submit" value="Search">
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




        <div class="container margin_30_40">
            <div class="row isotope-wrapper">
                @foreach ($restaurants as $restaurant)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 isotope-item popular">
                        <div class="strip">
                            <figure>
                                @if($restaurant->yums > 0)
                                    <span class="ribbon off">+ {{  $restaurant->yums  }} Yums</span>
                                @endif
                                <img src="{{ asset('assets-home/img/detail_3.jpg') }}"
                                    data-src="{{ asset('assets-home/img/home_section_1.jpg') }}" class="img-fluid lazy" alt="">


                                <a href="client/book/{{ $restaurant->id }}" class="strip_info">
                                    <small>{{ $restaurant->name }}</small>
                                    <div class="item_title">
                                        <h3>{{ $restaurant->name }}</h3>
                                        <small>{{ $restaurant->location }}</small>
                                        {{-- <small>{{ $restaurant->description }}</small> --}}
                                    </div>
                                </a>
                            </figure>
                            <ul>
                                <li><a class="loc_open" href="client/book/{{ $restaurant->id }}">Réservez ici</a></li>

                                {{-- <li><span>Avg. Price 24$</span></li> --}}
                                <li>
                                    {{-- <div class="score"><span>Superb<em>350 Reviews</em></span><strong>8.9</strong></div>
                                    --}}
                                </li>
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- /row -->
            <div class="pagination_fg">
                <a href="#">&laquo;</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">4</a>
                <a href="#">5</a>
                <a href="#">&raquo;</a>
            </div>
        </div>
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