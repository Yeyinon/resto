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
use Illuminate\Validation\Rule;
use Throwable;

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
        
        // Charger les menus avec les plats pour les afficher
        $menus = $restaurant->menus()->with('plats')->get();
        
        return view('client.reservation', [
            'restaurant' => $restaurant,
            'menus' => $menus
        ], compact('tableCount', 'comments'));
    }

    public function reservations(Request $request)
    {
        $client = Auth::guard('client')->user();
        $reservations = Reservation::where('client_id', $client->id)
            ->orderBy('reservation_date', 'desc')
            ->orderBy('reservation_time', 'desc')
            ->get();
        return view('client.mybooking', ['reservations' => $reservations]);
    }

    public function reserve(Request $request)
    {
        try {
            // Debug des données reçues
            \Log::debug('Données de réservation reçues:', $request->all());
            // dd($request->all()); // Vous pouvez décommenter temporairement pour voir les données

             // Vérifier si l'utilisateur est connecté
            if (!Auth::guard('client')->check()) {
                return redirect()->route('client.login')->with('error', 'Vous devez être connecté pour effectuer une réservation.');
            }

            // Validation des données - SANS LA RÈGLE 'guest_number'
            $validator = Validator::make($request->all(), [
                'reservation_tele' => 'required|string|max:255',
                'reservation_email' => 'required|email',
                'reservation_date' => 'required|date|after_or_equal:today',
                'reservation_time' => 'required|string',
                'table_id' => 'required|exists:tables,id',
                'restaurant_id' => 'required|exists:restaurants,id',
                // 'guest_number' => 'required|integer|min:1', // <-- SUPPRIMEE
            ], [
                'reservation_tele.required' => 'Le numéro de téléphone est requis.',
                'reservation_email.required' => 'L\'email est requis.',
                'reservation_email.email' => 'L\'email doit être valide.',
                'reservation_date.required' => 'La date de réservation est requise.',
                'reservation_date.after_or_equal' => 'La date de réservation doit être aujourd\'hui ou dans le futur.',
                'reservation_time.required' => 'L\'heure de réservation est requise.',
                'table_id.required' => 'Veuillez sélectionner une table.',
                'table_id.exists' => 'La table sélectionnée n\'existe pas.',
                'restaurant_id.required' => 'Le restaurant est requis.',
                'restaurant_id.exists' => 'Le restaurant sélectionné n\'existe pas.',
                // 'guest_number.required' => 'Le nombre d\'invités est requis.', // <-- SUPPRIMEE
                // 'guest_number.integer' => 'Le nombre d\'invités doit être un nombre entier.', // <-- SUPPRIMEE
                // 'guest_number.min' => 'Le nombre d\'invités doit être au moins de 1.', // <-- SUPPRIMEE
            ]);

            if ($validator->fails()) {
                \Log::debug('Erreurs de validation:', $validator->errors()->all());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Veuillez corriger les erreurs dans le formulaire.');
            }

            // Récupérer la table sélectionnée
            $table = Table::find($request->table_id);

            if (!$table) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'La table sélectionnée est introuvable.');
            }

            // Vérifier si la table est déjà réservée
            $existingReservation = Reservation::where('table_id', $table->id)
                ->where('reservation_date', $request->reservation_date)
                ->where('reservation_time', $request->reservation_time)
                ->where('status', '!=', 'cancelled') // Ignorer les réservations annulées
                ->first();

            if ($existingReservation) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'La table est déjà réservée à cette date et heure. Veuillez choisir une autre table ou une autre heure.');
            }

            // Création de la réservation
            $client = Auth::guard('client')->user();
            $reservation = new Reservation();
            $reservation->client_id = $client->id;
            $reservation->restaurant_id = $request->restaurant_id;
            $reservation->table_id = $request->table_id;
            $reservation->reservation_date = $request->reservation_date;
            $reservation->reservation_time = $request->reservation_time;
            $reservation->reservation_tele = $request->reservation_tele;
            $reservation->reservation_email = $request->reservation_email;
            // Supprimez la ligne qui tente d'assigner guest_number à la réservation
            // $reservation->guest_number = $request->guest_number; // <-- SUPPRIMEE
            $reservation->status = 'pending'; // Statut initial
            $reservation->archived = 0; // Définit la valeur par défaut pour 'archived'

            $reservation->save();

            /* Mettre à jour les informations du client si elles ont changé
            $client->reservation_tele = $request->reservation_tele; // <-- MODIFICATION ICI
            $client->email = $request->reservation_email;
            $client->save();*/

            return redirect()->route('client.reservation.confirmation', ['reservation' => $reservation->id])->with('success', 'Votre réservation a été effectuée avec succès !');

        } catch (\Exception | Throwable $e) {
            \Log::error('Erreur lors de la réservation:', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Une erreur s\'est produite lors de la réservation. Veuillez réessayer. Détails: ' . $e->getMessage());
        }
    }

    public function getAvailableTables(Request $request)
    {
        $request->validate([
            'restaurant_id' => 'required|integer',
            'date' => 'required|date',
            'time' => 'required|string',
        ]);
        
        $restaurantId = $request->restaurant_id;
        $date = $request->date;
        $time = $request->time;
        
        // Récupérer toutes les tables du restaurant avec tous les champs nécessaires
        // Assurez-vous que 'capacity' est sélectionnée si vous l'utilisez comme fallback
        $tables = Table::where('restaurant_id', $restaurantId)
                       ->select('id', 'number','guest_number', 'location', 'capacity') // Assurez-vous que 'capacity' est là si nécessaire
                       ->get();
        
        // Récupérer les tables déjà réservées à cette date et heure
        $reservedTableIds = Reservation::where('reservation_date', $date)
                                      ->where('reservation_time', $time)
                                      ->whereHas('table', function ($query) use ($restaurantId) {
                                          $query->where('restaurant_id', $restaurantId);
                                      })
                                      ->pluck('table_id')
                                      ->toArray();
        
        // Préparer les données de réponse avec tous les champs nécessaires
        $tableData = [];
        foreach ($tables as $table) {
            $tableData[] = [
                'id' => $table->id,
                'number' => $table->number,
                'guest_number' => $table->guest_number ?? $table->capacity ?? 0, // Utilise guest_number ou capacity
                'location' => $table->location ?? 'Non spécifiée',
                'is_available' => !in_array($table->id, $reservedTableIds)
            ];
        }
        
        return response()->json([
            'tables' => $tableData,
            'reservées' => $reservedTableIds
        ]);
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
        $client = Auth::guard('client')->user();
        return view('client.profile', compact('client'));
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
        $menus = $restaurant->menus()->with('plats')->get();
        return view('client.menu', compact('restaurant', 'menus'));
    }

    public function addToCart($id)
    {
        $menu = Menu::findOrFail($id);
        session()->push('cart', $menu);
        return redirect()->route('client.cart');
    }

    public function requestCancellation(Request $request)
    {
        $reservation = Reservation::with('restaurant')->findOrFail($request->reservation_id);

        if ($reservation->client_id !== auth()->guard('client')->id()) {
            return back()->with('error', 'Accès non autorisé.');
        }

        if (empty($reservation->reservation_date) || empty($reservation->reservation_time)) {
            return back()->with('error', 'Date ou heure de réservation manquante.');
        }

        $reservationDate = Carbon::parse($reservation->reservation_date . ' ' . $reservation->reservation_time);
        $now = now();
        $hoursBeforeReservation = $now->diffInHours($reservationDate, false);

        if ($hoursBeforeReservation < 48) {
            return back()->with('error', 'Votre délai pour annuler la réservation est dépassé. Vous pouvez annuler 48h avant la réservation.');
        }

        Notification::route('mail', $reservation->restaurant->email)
            ->notify(new ReservationCancelledByClient($reservation));

        $reservation->delete();

        return redirect()->route('client.reservations')->with('success', 'Votre réservation a été annulée avec succès. Le restaurant a été notifié.');
    }

    // Méthode pour mettre à jour le profil du client
    public function updateProfile(Request $request)
    {
        $client = Auth::guard('client')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                // S'assurer que l'email est unique sauf pour l'utilisateur actuel
                Rule::unique('clients')->ignore($client->id),
            ],
            'phone' => 'nullable|string|max:20', // Exemple: téléphone optionnel
            'address' => 'nullable|string|max:255', // Exemple: adresse optionnelle
            'current_password' => 'nullable|required_with:new_password|current_password:client', // 'current_password:client' vérifie le mot de passe actuel pour le guard 'client'
            'new_password' => 'nullable|min:8|confirmed', // 'confirmed' vérifie la correspondance avec new_password_confirmation
        ]);

        $client->name = $request->input('name');
        $client->email = $request->input('email');
        $client->phone = $request->input('phone');
        $client->address = $request->input('address');

        if ($request->filled('new_password')) {
            $client->password = Hash::make($request->input('new_password'));
        }

        $client->save();

        return redirect()->back()->with('success', 'Votre profil a été mis à jour avec succès !');
    }

    // Méthode pour afficher l'historique des Yums du client
    public function yumsHistory()
    {
        $client = Auth::guard('client')->user();
        // Ici, vous devriez récupérer les transactions de Yums du client.
        // Cela suppose que vous avez une relation `yumsTransactions` définie dans votre modèle Client.
        // Exemple : un modèle `YumTransaction` lié au client.
        // Si vous n'avez pas de table de transactions, vous pourriez simplement passer le solde.
        
        // Exemple avec une relation `yumsTransactions` :
        $yumsTransactions = $client->yumsTransactions()->latest()->get(); 

        // Si vous n'avez pas de table de transactions dédiée, vous pouvez passer une collection vide
        // $yumsTransactions = collect(); 

        return view('client.yums_history', compact('client', 'yumsTransactions'));
    }
}