<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    public function login()
    {
        return view('admin.login');
    }
    public function dashboard()
    {
        $nbr_resto = Restaurant :: count();
        $nbr_client = Client :: count();
        $restaurants = Restaurant::all();
        foreach ($restaurants as $restaurant) {
            $reservationCount = Reservation::whereHas('table', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })->count();

            $restaurant->reservationCount = $reservationCount;
        }
        return view('admin.dashboard',compact('nbr_resto','nbr_client','restaurants'));
    }
    public function profile()
    {
        return view('admin.profile');
    }

    public function test(Request $request){
//         $inputDateTime = $request->input('date');
//         $carbonDateTime = Carbon::parse($inputDateTime);

//         $date = $carbonDateTime->format('Y-m-d');
//         $time = $carbonDateTime->format('H:i:s');
// dd($date ,$time);
return $request;

    }
    public function connect(Request $request)
    {
        //dd($request->all());
        $check = $request->all();
        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            toastr()->success('Connectez-vous avec succès');
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', 'Email ou mot de passe invalide');
        }
        //return view('restaurant.index');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        toastr()->info('Se déconnecter avec succès');
        return redirect('/');
    }
     public function register()
    {
        return view('admin.admin_register');
     }

    public function create(Request $request)
    {
       // dd($request->all());
       Admin::insert([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'created_at' => Carbon::now(),
       ]);
       toastr()->success('Données enregistrées avec succès');
        return redirect()->route("admin.dashboard");


    }
}

