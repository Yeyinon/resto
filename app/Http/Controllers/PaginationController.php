<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant;

class PaginationController extends Controller
{

    public function viewAll()
    {
        $restaurants = Restaurant::latest()->paginate(8); // 8 restaurants par page
        $nbr_resto = Restaurant::count();
    
        return view('nom_de_ta_vue', compact('restaurants', 'nbr_resto'));
    }
    
}
