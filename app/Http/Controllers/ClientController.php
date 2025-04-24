<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Table;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReservationCancelledByClient;
use App\Models\Menu;

class ClientController extends Controller
{
    //
    public function login()
    {
        return view('client.login');
    }
    public function book(Request $request)
    {
        $restaurant = Restaurant::find($request->id);
        $tableCount = Table::whereHas('restaurant', function ($query) use ($restaurant) {
            $query->where('restaurant_id', $restaurant->id);
        })->count();
        $comments = $restaurant->comments;
        // return $tableCount;
        // $restaurant = $restaurant->tables->where('status',"=",'Disponible')->groupBy('guest_number');
// return $restaurant;
        return view('client.reservation', ['restaurant' => $restaurant], compact('tableCount', 'comments'));
    }

    public function reservations(Request $request)
    {
        $client = Auth::guard('client')->user();
        $reservations = Reservation::where('client_id', $client->id)->get();
        return view('client.mybooking', ['reservations' => $reservations]);
    }

    public function reserve(Request $request)
    {
        $table = Table::with('restaurant')->findOrFail($request->table_id);

        $existingReservation = Reservation::where('table_id', $table->id)
            ->where('reservation_date', $request->reservation_date)
            ->where('reservation_time', $request->reservation_time)
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'La table est déjà réservée à cette date et heure.');
        }

        $client = Client::findOrFail($request->client_id);

        // 🔥 On récupère automatiquement le restaurant associé à la table
        $restaurant = $table->restaurant;

        // Ajout des yums
        $client->yums += $restaurant->yums;
        $client->save();

        // 💡 Création de la réservation AVEC le restaurant récupéré automatiquement
        $reservation = Reservation::create([
            'client_id' => $client->id,
            'table_id' => $table->id,
            'reservation_tele' => $request->reservation_tele,
            'reservation_email' => $request->reservation_email,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'restaurant_id' => $restaurant->id, // Auto
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('client.reservation.confirmation', ['reservation' => $reservation->id]);
    }


    public function clients()
    {
        $clients = Client::all();
        return view("admin.clients", compact("clients"));
    }

    public function dashboard()
    {
        $restaurants = Restaurant::all();
        return view('client.index', compact("restaurants"));
    }
    public function profile()
    {
        return view('client.client_profile');
    }
    public function reservation()
    {
        $restaurants = restaurant::all();
        return view('client.reservation')->with([
            "restaurants" => $restaurants,
        ]);
    }

    public function connect(Request $request)
    {
        //dd($request->all());
        $check = $request->all();
        if (Auth::guard('client')->attempt(['email' => $check['email'], 'password' => $check['password']])) {
            toastr()->success('Connexion reussie');
            return redirect()->route('view_all');
        } else {
            toastr()->error('Email ou mot de passe invalide');
            return back();
        }
    }
    public function register()
    {
        return view('client.register');
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:clients,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Le nom est requis.',
            'email.required' => 'L\'adresse email est requise.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au moins 6 caractères.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $client = Client::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'created_at' => Carbon::now(),
        ]);

        Auth::guard("client")->login($client);
        toastr()->success('Inscription réussie.');
        return redirect()->route('view_all');
    }

    public function update(Request $request)
    {

        $client = Client::find($request->id);
        $client->name = $request->name;
        $client->email = $request->email;
        // $client->password = Hash::make($request->password);
        $client->save();
        toastr()->success('Données enregistrées avec succès');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $client = Client::findOrFail($request->id);
        $client->delete();
        toastr()->error('Le client a été bien supprimé !', " ");
        return redirect()->route("Admin.clients");
    }
    public function logout()
    {
        Auth::guard('client')->logout();
        toastr()->info('Déconnexion reussie');
        return redirect('/');
    }


    public function showMenu($restaurant_id)
    {
        $restaurant = Restaurant::findOrFail($restaurant_id);

        // Charger les menus avec les plats
        $menus = $restaurant->menus()->with('plats')->get();

        return view('client.menu', compact('restaurant', 'menus'));
    }





    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        // Ajouter au panier, par exemple avec la session
        session()->push('cart', $menu);

        return redirect()->route('client.cart');
    }

    public function requestCancellation(Request $request)
    {
        $reservation = Reservation::with('restaurant')->findOrFail($request->reservation_id);

        // Vérifie que la réservation appartient au client connecté
        if ($reservation->client_id !== auth()->guard('client')->id()) {
            return back()->with('error', 'Accès non autorisé.');
        }

        // Débogage pour vérifier les valeurs avant de tenter de les parser
        \Log::debug('Reservation Date: ' . $reservation->reservation_date);
        \Log::debug('Reservation Time: ' . $reservation->reservation_time);


        // Vérifie que la date et l'heure existent
        if (empty($reservation->reservation_date) || empty($reservation->reservation_time)) {
            return back()->with('error', 'Date ou heure de réservation manquante.');
        }

        $reservationDate = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
        $now = now();

        $hoursBeforeReservation = $now->diffInHours($reservationDate, false);

        if ($hoursBeforeReservation < 48) {
            return back()->with('error', 'Votre délai pour annuler la réservation est dépassé. Vous pouvez annuler 48h avant la réservation.');
        }

        // Notification au restaurant
        Notification::route('mail', $reservation->restaurant->email)
            ->notify(new ReservationCancelledByClient($reservation));

        // Supprime la réservation
        $reservation->delete();

        return redirect()->route('client.reservations')->with('success', 'Votre réservation a été annulée avec succès. Le restaurant a été notifié.');
    }



}
