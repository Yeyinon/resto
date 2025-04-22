@extends('restaurant.master')
@section('restaurant')
    <!-- /Navigation-->

    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Mon profil</li>
            </ol>
            <div class="box_general padding_bottom">
                <div class="header_box version_2">
                    <h2><i class="fa fa-user"></i>Détails du profil</h2>
                </div>
                {{-- <div class="row"> --}}
                    {{-- <div class="col-md-4">
                        <div class="form-group">
                            <label>Your photo :</label><br>
                            <img src="{{ asset('img/resto_user.png') }}" width="170" height="170"></img>
                        </div>
                    </div> --}}
                {{-- </div> --}}
                    <form method="post" action="{{ route('restaurant.update.profile') }}">
                        @csrf
                        {{-- <div class="col-md-8 add_top_30"> --}}
                            <input type="hidden" name="id" value="{{ Auth::guard('restaurant')->user()->id }}">
                            <input type="hidden" name="status" value="{{ Auth::guard('restaurant')->user()->status }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nom</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ Auth::guard('restaurant')->user()->name }}">
                                    </div>
                                </div>

                            </div>
                            <!-- /row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ Auth::guard('restaurant')->user()->email }}">
                                    </div>
                                </div>

                            </div>

                            <!-- /row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Emplacement</label>
                                        <input type="text" class="form-control" name="location"
                                            value="{{ Auth::guard('restaurant')->user()->location }}">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Offre yums ( 100 yums = 1000XOF de rabais )</label>
                                        <input type="number" class="form-control" name="yums"
                                            value="{{ Auth::guard('restaurant')->user()->yums }}">
                                    </div>
                                </div>
                            </div>
                            <!-- /row-->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea rows="6" type="text" class="form-control" name="description"
                                            value="{{ Auth::guard('restaurant')->user()->description }}">{{ Auth::guard('restaurant')->user()->description }}</textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- /row-->
                            {{-- <p><a href="#0" class="btn_1 medium">Save</a></p> --}}
                            <div class=><input type="submit" class="btn_1" value="Enregistrer">
                            </div>
                        {{-- </div> --}}
                    </form>
                </div>
            </div>

        </div>
        <!-- /row-->
    </div>
    <!-- /.container-fluid-->
@endsection
