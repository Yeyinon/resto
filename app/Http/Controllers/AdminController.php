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
        // Nombre de restaurants
        $nbr_resto = Restaurant::count();
        $nbr_resto_last_week = Restaurant::where('created_at', '<', Carbon::now()->subWeek())->count();
        $resto_trend_percentage = $nbr_resto_last_week > 0 
            ? round(($nbr_resto - $nbr_resto_last_week) / $nbr_resto_last_week * 100) 
            : 100;
        
        // Nombre de clients
        $nbr_client = Client::count();
        $nbr_client_last_month = Client::where('created_at', '<', Carbon::now()->subMonth())->count();
        $client_trend_percentage = $nbr_client_last_month > 0 
            ? round(($nbr_client - $nbr_client_last_month) / $nbr_client_last_month * 100) 
            : 100;
        
        // Récupération des restaurants avec leur nombre de réservations
        $restaurants = Restaurant::all();
        $reservations_total = 0;
        $reservations_last_week = 0;
        
        foreach ($restaurants as $restaurant) {
            // Réservations actuelles
            $reservationCount = Reservation::whereHas('table', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })->count();
            $restaurant->reservationCount = $reservationCount;
            $reservations_total += $reservationCount;
            
            // Réservations de la semaine dernière
            $reservationLastWeekCount = Reservation::whereHas('table', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })->where('created_at', '<', Carbon::now()->subWeek())->count();
            $reservations_last_week += $reservationLastWeekCount;
        }
        
        // Calcul de la tendance des réservations
        $reservation_trend_percentage = $reservations_last_week > 0 
            ? round(($reservations_total - $reservations_last_week) / $reservations_last_week * 100) 
            : 100;
            
        // Calcul de la note moyenne (simulé pour l'exemple)
        $rating_avg = 4.8; // À remplacer par le calcul réel depuis la base de données
        $rating_last_month = 4.6; // À remplacer par le calcul réel depuis la base de données
        $rating_trend = $rating_avg - $rating_last_month;
        
        // Trier les restaurants par nombre de réservations (pour un meilleur affichage du graphique)
        $restaurants = $restaurants->sortByDesc('reservationCount');
        
        return view('admin.dashboard', compact(
            'nbr_resto', 'nbr_client', 'restaurants', 'reservations_total',
            'resto_trend_percentage', 'client_trend_percentage', 'reservation_trend_percentage',
            'rating_avg', 'rating_trend'
        ));
    }
    
    public function profile()
    {
        return view('admin.profile');
    }

    public function test(Request $request)
    {
        return $request;
    }
    
    public function connect(Request $request)
    {
        $check = $request->all();
        if (Auth::guard('admin')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            toastr()->success('Connexion réussie');
            return redirect()->route('admin.dashboard');
        } else {
            return back()->with('error', 'Email ou mot de passe invalide');
        }
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();
        toastr()->info('Déconnexion réussie');
        return redirect('/');
    }
    
    public function register()
    {
        return view('admin.admin_register');
    }

    public function create(Request $request)
    {
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