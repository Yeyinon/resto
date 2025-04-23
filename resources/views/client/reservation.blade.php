@extends('client.master')
@section('client')
    <title>Resto - Reservation</title>
    <main>
        <div class="col-lg-8">

        </div>
        <div class="container margin_detail">
            <div class="row">
                <div class="col-lg-8">

                    <div class="detail_page_head clearfix">
                        <div class="breadcrumbs">
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="{{ route('view_all') }}">View restaurant</a></li>
                                <li>Reservation</li>
                            </ul>
                        </div>
                        {{-- <div class="title">
                            <br>
                            <h1>{{ $restaurant->name }}</h1><br>
                            <h5>{{ $restaurant->location }}</h5>
                            <h5>{{ $restaurant->description }}</h5>
                            {{-- <a href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+H%C3%B4pitaux+de+Paris+(AP-HP)+-+Si%C3%A8ge!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="blank">Get directions</a> --}}
                        {{-- <ul class="tags">
                            <li><a href="#0">Pizza</a></li>
                            <li><a href="#0">Italian Food</a></li>
                            <li><a href="#0">Best Price</a></li>
                        </ul> --}}
                        {{-- </div>  --}}

                    </div>

                    <div class="tab-content" role="tablist">
                        <div class="card-body info_content">
                            <div class="other_info">
                                <h2>{{ $restaurant->name }}</h2>
                                <div class="row">

                                    <div class="col-md-4">
                                        <h3>Plus à propos de {{ $restaurant->name }}</h3>
                                        <p><strong>Description </strong><br> {{ $restaurant->description }}</p>
                                        <p><strong>Table</strong><br> Plus de {{ $tableCount }}</p>
                                        <p><strong>Yums offre</strong><br><span class="loc_closed">+ {{ $restaurant->yums }} yums</span></p>

                                    </div>
                                    <div class="col-md-4">
                                        <h3></h3><br>
                                            <p><strong>Address </strong><br>{{ $restaurant->location }}</p>
                                            <a href="https://www.google.com/maps/dir//Assistance+%E2%80%93+H%C3%B4pitaux+De+Paris,+3+Avenue+Victoria,+75004+Paris,+Francia/@48.8606548,2.3348734,14z/data=!4m15!1m6!3m5!1s0x47e66e1de36f4147:0xb6615b4092e0351f!2sAssistance+Publique+-+H%C3%B4pitaux+de+Paris+(AP-HP)+-+Si%C3%A8ge!8m2!3d48.8568376!4d2.3504305!4m7!1m0!1m5!1m1!1s0x47e67031f8c20147:0xa6a9af76b1e2d899!2m2!1d2.3504327!2d48.8568361" target="{{ $restaurant->location }}">Get directions</a></p>
                                            {{-- <strong>Follow Us</strong><br> --}}

                                    </div>
                                    <div class="col-md-4">
                                        {{-- <h3>Services</h3>
                                        <p><strong>Credit Cards</strong><br> Mastercard, Visa, Amex</p>
                                        <p><strong>Other</strong><br> Wifi, Parking, Wheelchair Accessible</p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="detail_page_head clearfix">
                        <div class="rating">
                            <div class="score"><span>Nous vous remercions d'avoir choisi notre restaurant pour votre
                                    prochain repas. Nous serions ravis de vous accueillir
                                    <em>{{ $restaurant->name }}</em></span>
                            </div>
                        </div>
                        <br>
                        {{-- <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                            <input type="hidden" name="client_id" value="{{ Auth::guard('client')->id() }}">
                            <textarea name="comment" rows="4" required></textarea>
                            <button type="submit">Submit Comment</button>
                        </form> --}}
                        <!-- index.blade.php -->

                        <hr>
                        <div class="box_general write_review">
                            <div class="form-group">
                                <form action="{{ route('comments.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">
                                    <input type="hidden" name="client_id" value="{{ Auth::guard('client')->id() }}">
                                    <label>Votre avis</label>
                                    <textarea name="comment" required class="form-control" style="height: 100px;"
                                        placeholder="Rédigez votre avis pour aider les autres à en savoir plus sur cette entreprise en ligne"></textarea>
                                    <button type="submit" class="btn_1" style="text-align: left">Poster le commentaire</button><br>
                                </form>
                            </div>
                            <br><label>Commentaires</label>
                        </div>
                        @foreach ($comments as $comment)
                        <div class="review_card">
                            <div class="row">
                                <div class="col-md-2 user_info">
                                        <figure><img src="{{ asset('img/client_user.png') }}" alt=""></figure>
                                        <h5>{{ $comment->client->name }}</h5>
                                </div>
                                <div class="col-md-10 review_content">
                                    <div class="clearfix add_bottom_15">
                                        {{-- <span class="rating">8.5<small>/10</small> <strong>Rating average</strong></span> --}}
                                        <em>{{ $comment->created_at }}</em>
                                    </div>
                                    <h4>{{ $comment->client->name }}</h4>
                                    <p>{{ $comment->comment }}</p>

                                </div>
                            </div>
                            <!-- /row -->
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- /col -->

                <div class="col-lg-4" id="sidebar_fixed">
                    <div class="box_booking">
                        <div class="head">
                            <h3>Réservez votre table</h3>
                            <div class="offer">Offrez {{ $restaurant->yums }} yums !
                            </div>
                        </div>
                        <div class="main">
                            <form method="post" action="{{ route('client.reservation.create') }}">
                                @csrf
                                <input type="hidden" name="client_id" value="{{ Auth::guard('client')->id() }}">
                                <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

                                <div class="input-group mb-3">
                                    <span class="input-group-text">Date</span>
                                    <input required class="form-control date-input" type="date" name="reservation_date"
                                        min="{{ date('Y-m-d') }}">
                                </div>


                                <input type="text" id="datepicker_field">
                                <div id="DatePicker"></div>

                                <div class="dropdown time">
                                    <a href="#" data-bs-toggle="dropdown">Heure <span id="selected_time"></span></a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-content">
                                            <h4>Déjeuner</h4>
                                            <div class="radio_select add_bottom_15">
                                                <ul>
                                                    <li>
                                                        <input type="radio" id="time_1" name="reservation_time"
                                                            value="12:00:00">
                                                        <label for="time_1">12.00<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_2" name="reservation_time"
                                                            value="12:30:00">
                                                        <label for="time_2">12.30<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_3" name="reservation_time"
                                                            value="13:00:00">
                                                        <label for="time_3">1.00 <em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_4" name="reservation_time"
                                                            value="13:30:00">
                                                        <label for="time_4">1.30 <em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_5" name="reservation_time"
                                                            value="14:00:00">
                                                        <label for="time_5">2.00 <em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_6" name="reservation_time"
                                                            value="14:30:00">
                                                        <label for="time_6">2.30 <em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_7" name="reservation_time"
                                                            value="15:00:00">
                                                        <label for="time_7">3.00 <em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_8" name="reservation_time"
                                                            value="15:30:00">
                                                        <label for="time_8">3.30 <em>PM</em></label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /time_select -->
                                            <h4>Dîner</h4>
                                            <div class="radio_select add_bottom_15">
                                                <ul>
                                                    <li>
                                                        <input type="radio" id="time_11" name="reservation_time"
                                                            value="20:00:00">
                                                        <label for="time_11">8.00<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_12" name="reservation_time"
                                                            value="20:30:00">
                                                        <label for="time_12">8.30<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_13" name="reservation_time"
                                                            value="21:00:00">
                                                        <label for="time_13">9.00<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_14" name="reservation_time"
                                                            value="21:30:00">
                                                        <label for="time_14">9.30<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_15" name="reservation_time"
                                                            value="22:00:00">
                                                        <label for="time_15">10.00<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_16" name="reservation_time"
                                                            value="22:30:00">
                                                        <label for="time_16">10.30<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_17" name="reservation_time"
                                                            value="23:00:00">
                                                        <label for="time_17">11.00<em>PM</em></label>
                                                    </li>
                                                    <li>
                                                        <input type="radio" id="time_18" name="reservation_time"
                                                            value="23:30:00">
                                                        <label for="time_18">11.30<em>PM</em></label>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!-- /time_select -->
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="input-group mb-3">
                                    <span class="input-group-text">Heure</span>
                                    <select required class="form-select" name="reservation_time">
                                        <option value="" disabled selected>sélectionner</option>
                                        <optgroup label="Déjeuner">
                                            <option value="12:00:00">12:00 AM</option>
                                            <option value="12:30:00">12.30 AM</option>
                                            <option value="01:00:00">1.00 AM</option>
                                            <option value="01:30:00">1.30 AM</option>
                                        </optgroup>
                                        <optgroup label="Dîner">
                                            <option value="08:00:00">20.00 PM</option>
                                            <option value="08:30:00">20.30 PM</option>
                                            <option value="09:00:00">21.00 PM</option>
                                            <option value="09:30:00">21.30 PM</option>
                                        </optgroup>
                                    </select>
                                </div> --}}
                                <div class="dropdown people">
                                    <a href="#" data-bs-toggle="dropdown">Personne <span
                                            id="selected_people"></span></a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-content">
                                            <h4>Combien de personnes?</h4>
                                            <div class="radio_select">
                                                <ul>
                                                    {{-- @foreach ($restaurant->tables->where('status', '=', 'Disponible')->groupBy('guest_number') as $table)
                                                        @if ($table->count() > 1)
                                                            <p>{{ $table[0]->guest_number }} </p>

                                                            {{-- @foreach ($table as $x)
                                                                <p>{{ $x->guest_number }} / {{ $x->number }}</p>
                                                            @endforeach --}}
                                                    {{-- @else
                                                            <p>{{ $table[0]->guest_number }}/{{ $table[0]->number }}</p> --}}
                                                    {{-- <p>{{ $table->location }}</p> --}}
                                                    {{-- <p>{{ $table->count() }}</p> --}}
                                                    {{-- <p>{{ $table->count() }}</p> --}}
                                                    {{-- @endif
                                                    @endforeach --}}


                                                    @foreach ($restaurant->tables->where('status', '=', 'Disponible')->groupBy('guest_number') as $table)
                                                        @if ($table->count() > 1 && $table[0]->location != $table[1]->location)
                                                            <li>
                                                                <input type="radio" id="people_{{ $table[0]->id }}"
                                                                    name="table_id" value="{{ $table[0]->id }}">
                                                                <label
                                                                    for="people_{{ $table[0]->id }}">{{ $table[0]->guest_number }}<em>{{ $table[0]->location }}</em>
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <input type="radio" id="people_{{ $table[1]->id }}"
                                                                    name="table_id" value="{{ $table[1]->id }}">
                                                                <label
                                                                    for="people_{{ $table[1]->id }}">{{ $table[1]->guest_number }}<em>{{ $table[1]->location }}</em>
                                                                </label>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <input type="radio" id="people_{{ $table[0]->id }}"
                                                                    name="table_id" value="{{ $table[0]->id }}">
                                                                <label
                                                                    for="people_{{ $table[0]->id }}">{{ $table[0]->guest_number }}<em>{{ $table[0]->location }}</em>
                                                                </label>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <!-- /people_select -->
                                        </div>
                                    </div>
                                </div>
                                <!-- /dropdown -->
                                {{-- <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}"> --}}
                                {{-- <div class="input-group mb-3">
                                    <span class="input-group-text">Combien de personnes?</span>
                                    <select required class="form-control " id="number_of_people" name="table_id">
                                        <option value="" disabled selected>sélectionner</option>
                                        @foreach ($restaurant->tables as $table)
                                            @if ($table->status == 'Disponible')
                                                <option value="{{ $table->id }}">
                                                    <strong>{{ $table->guest_number }}</strong> et {{ $table->location }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div> --}}
                                <div class="input-group mb-3">
                                    <span class="input-group-text">E-mail</span>
                                    <input class="form-control " required type="email" name="reservation_email"
                                        @if (Auth::guard('client')->check()) value="{{ Auth::guard('client')->user()->email }}">
                                        @else
                                        placeholder="Votre email"> @endif
                                        </div>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text">Téléphone</span>
                                        <input class="form-control " required type="text" name="reservation_tele"
                                            placeholder="Votre téléphone">
                                    </div>
                                    <button type="submit" class="btn_1 full-width mb_5">Réservez maintenant</button>
                                    <div class="text-center"><small>Pas d'argent facturé sur ces étapes</small></div>

                            </form>
                        </div>
                    </div>
                    <div class="col-lg" id="sidebar_fixed">
                        <div class="box_booking">
                            <div class="main">
                                Réservez sur Resto pour cumuler des Yums et profiter de remises fidélité exclusives
                            </div>
                        </div>
                    </div>
                    <!-- /dropdown -->

                    <!-- /dropdown -->
                    {{-- <a href="wishlist.html" class="btn_1 full-width outline wishlist"><i class="icon_heart"></i> Add to wishlist</a> --}}
                </div>
            </div>
            <!-- /box_booking -->
            {{-- <ul class="share-buttons">
                    <li><a class="fb-share" href="#0"><i class="social_facebook"></i> Share</a></li>
                    <li><a class="twitter-share" href="#0"><i class="social_twitter"></i> Share</a></li>
                    <li><a class="gplus-share" href="#0"><i class="social_googleplus"></i> Share</a></li>
                </ul> --}}
        </div>

        </div>
        <!-- /row -->
        </div>
        <!-- /container -->

    </main>
    <script>
        // Datepicker
        var dates = {}
        dates[new Date('10/23/2019')] = '-40%';
        dates[new Date('12/14/2019')] = '-20%';
        dates[new Date('01/25/2020')] = '-30%';

        $('#DatePicker').datepicker({
            showButtonPanel: false,
            inline: true,
            altField: '#datepicker_field',
            minDate: 0,
            beforeShowDay: function(date) {

                var hlText = dates[date];
                var date2 = new Date(date);
                var tglAja = date2.getDate();
                if (hlText) {
                    updateDatePickerCells(tglAja, hlText);
                    return [true, "", hlText];
                } else {
                    return [true, '', ''];
                }
            },
        });

        function updateDatePickerCells(a, b) {

            var num = parseInt(a);

            setTimeout(function() {

                $('.ui-datepicker td > *').each(function(idx, elem) {

                    if ((idx + 1) == num) {
                        value = b;
                    } else {
                        value = 0;
                    }

                    var className = 'datepicker-content-' + CryptoJS.MD5(value).toString();

                    if (value == 0)
                        addCSSRule('.ui-datepicker td a.' + className +
                            ':after {content: "\\a0";}'); //&nbsp;
                    else
                        addCSSRule('.ui-datepicker td a.' + className + ':after {content: "' + value +
                            '";}');

                    $(this).addClass(className);
                });
            }, 0);
        }
        var dynamicCSSRules = [];

        function addCSSRule(rule) {
            if ($.inArray(rule, dynamicCSSRules) == -1) {
                $('head').append('<style>' + rule + '</style>');
                dynamicCSSRules.push(rule);
            }
        }

        $('#datepicker_field').on('change', function() {
            $('#DatePicker').datepicker('setDate', $(this).val());
        });
    </script>
@endsection
