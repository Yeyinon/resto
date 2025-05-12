<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Table;
use Illuminate\Support\Facades\Hash;
// use Carbon\Carbon;
use Illuminate\Support\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Validator;


class RestaurantController extends Controller
{
    //
    public function login()
    {
        return view('restaurant.login');
    }
    public function profile()
    {
        $restaurants = Restaurant::all();
        return view("restaurant.profile", compact("restaurants"));
    }
    public function restaurants()
    {
        $restaurants = Restaurant::all();
        return view("admin.restaurants", compact("restaurants"));
    }




    public function dashboard()
{
    $restaurant = Auth::guard('restaurant')->user();
    $restaurantId = $restaurant->id;

    $reservations = Reservation::where('created_at', '>=', now()->subDays(7))
        ->whereHas('table.restaurant', function ($query) use ($restaurantId) {
            $query->where('id', $restaurantId);
        })
        ->get();

    $labels = [];
    $data = [];
    $locale = 'fr'; // Set the locale to French

    for ($i = 6; $i >= 0; $i--) {
        $date = Carbon::now()->subDays($i)->locale($locale);
        $formattedDate = $date->isoFormat('ddd'); // Format the day name according to the locale
        $count = Reservation::whereDate('created_at', $date->format('Y-m-d'))
            ->whereHas('table.restaurant', function ($query) use ($restaurantId) {
                $query->where('id', $restaurantId);
            })
            ->count();
        $labels[] = $formattedDate;
        $data[] = $count;
    }

    $chartLabels = json_encode($labels);
    $chartData = json_encode($data);

    // Calculate unique clients
    $uniqueClients = Reservation::whereHas('table', function ($query) use ($restaurant) {
        $query->where('restaurant_id', $restaurant->id);
    })
    ->distinct('client_id')
    ->count('client_id');

    // Reservation count
    $reservationCount = Reservation::whereHas('table', function ($query) use ($restaurant) {
        $query->where('restaurant_id', $restaurant->id);
    })->count();

    // Calculate table count
    $tableCount = Table::where('restaurant_id', $restaurant->id)->count();

    // Calculate reservation rate
    $reservationRate = $tableCount > 0 
        ? (($reservationCount / $tableCount) * 100) 
        : 0;

    // Total Revenue (default to 0 if no specific revenue column)
    $totalRevenue = 0; // You may need to adjust this based on your actual revenue calculation

    // Revenue Growth (default to 0)
    $revenueGrowth = 0; // You may need to adjust this based on your actual revenue calculation

    $tables = Table::all();
    $latestReservation = Reservation::whereHas('table', function ($query) use ($restaurant) {
        $query->where('restaurant_id', $restaurant->id);
    })->latest()->first();

    return view('restaurant.dashboard', compact(
        'restaurant', 
        'reservationCount', 
        'uniqueClients', 
        'reservationRate', 
        'totalRevenue', 
        'revenueGrowth',
        'tableCount', 
        'reservations', 
        'chartLabels', 
        'chartData', 
        'tables', 
        'latestReservation'
    ));
}

    public function connect(Request $request)
    {
        //dd($request->all());
        $check = $request->all();
        if (Auth::guard('restaurant')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            toastr()->success('Connexion reussie');
            return redirect()->route('restaurant.dashboard');
        } else {
            toastr()->error('Email ou mot de passe invalide');
            return back();
        }
        //return view('restaurant.index');
    }
    public function logout()
    {
        Auth::guard('restaurant')->logout();
        toastr()->info('Déconnexion reussie');
        return redirect('/');
    }
    public function register()
    {
        return view('restaurant.register');
    }
    // public function info()
    // {
    //     return view('info');
    // }


    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'email' => 'required|string|email|max:255|unique:restaurants,email',
            'password' => 'required|string|min:6|confirmed',
            'privacy_agreed' => 'accepted', // validation Laravel
            'phone_number' => 'required|regex:/^[0-9]+$/',
            'restaurant_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation de l'image
        ], [
            'name.required' => 'Le nom est requis.',
            'location.required' => 'La localisation est requise.',
            'description.required' => 'La description est requise.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'phone_number.regex'=>'Le Numéro de téléphone dois être une suite de chiffre'
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $restaurant = Restaurant::create([
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'created_at' => Carbon::now(),
            'privacy_agreed' => true, // on stocke le consentement
        ]);
        
        // Traitement de l'image si elle est présente
        if ($request->hasFile('restaurant_image')) {
            $image = $request->file('restaurant_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            
            // Stocker l'image dans le dossier public/uploads/restaurants
            $image->move(public_path('uploads/restaurants'), $imageName);
            
            // Mettre à jour directement l'objet restaurant avec le chemin de l'image
            $restaurant->image_path = 'uploads/restaurants/' . $imageName;
            $restaurant->save();
        }

        $restaurant->privacy_agreed = $request->has('privacy_agreed');
        $restaurant->save();
    
        Auth::guard("restaurant")->login($restaurant);
    
        toastr()->success('Inscription réussie.');
        return redirect()->route("restaurant.dashboard");
    }

    public function update(Request $request)
    {
        $restaurant = Restaurant::find($request->id);
        $restaurant->name = $request->name;
        $restaurant->email = $request->email;
        $restaurant->location = $request->location;
        $restaurant->yums = $request->yums;
        $restaurant->description = $request->description;
        // $restaurant->password = Hash::make($request->password);
        $restaurant->save();
        toastr()->success('Données enregistrées avec succès');
        return redirect()->back();
    }


    public function destroy(Request $request)
    {
        $restaurant = Restaurant::findOrFail($request->id);
        $restaurant->delete();
        toastr()->error('Le restaurant a été bien supprimé !', " ");
        return redirect()->route("Admin.restaurants");
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $location = $request->input('location');

        $restaurants = Restaurant::query()
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%$query%");
            })
            ->when($location, function ($q) use ($location) {
                return $q->where('location', 'like', "%$location%");
            })
            ->get();

        return view('search_results', [
            'restaurants' => $restaurants,
            'nbr_resto' => $restaurants->count()
        ]);
    }

    public function confirmation($id)
    {
        // Récupérer la réservation et le restaurant associé
        $reservation = Reservation::with('restaurant')->findOrFail($id);

        // Récupérer le restaurant directement
        $restaurant = $reservation->restaurant;

        // Retourner la vue avec les données
        return view('client.confirm', compact('reservation', 'restaurant'));
    }

    public function showMenu($id)
    {
        // Trouver le restaurant par son identifiant
        $restaurant = Restaurant::findOrFail($id);

        // Passer cette variable à la vue
        return view('restaurant.menu', compact('restaurant'));
    }
    
}