<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Table;
use App\Models\Menu; // Ajout de l'import pour Menu
use App\Models\Comment; // Ajout de l'import pour Comment
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusMail;

class ReservationController extends Controller
{
    public function showReservationPage(Request $request, $restaurant_id)
{
    // Récupérer le restaurant avec ses menus et plats
    $restaurant = Restaurant::findOrFail($restaurant_id);
    
    // Charger explicitement les menus et les plats associés
    $menus = Menu::with('plats')
                ->where('restaurant_id', $restaurant_id)
                ->get();
    
    // Compter le nombre de tables
    $tableCount = Table::where('restaurant_id', $restaurant_id)->count();

    // Récupérer les commentaires
    $comments = Comment::with('client')
                      ->where('restaurant_id', $restaurant_id)
                      ->orderBy('created_at', 'desc')
                      ->get();

    // Renvoyer la vue avec toutes les données nécessaires
    return view('client.reservation', compact(
        'restaurant',
        'tableCount',
        'comments',
        'menus'
    ));
}

    /**
     * Approuver une réservation.
     */
    public function approve(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->status = 'approved'; // Changer le statut à approuvé
        $reservation->save();

        // Envoi de l'e-mail de confirmation au client
        Mail::to($reservation->client->email)->send(new ReservationStatusMail($reservation, 'approved'));

        toastr()->success('Réservation approuvée avec succès!', " ");
        return redirect()->route('restaurant.reservations');
    }

    /**
     * Refuser une réservation avec un motif.
     */
    public function reject(Request $request, $id)
    {
        // Récupère la réservation
        $reservation = Reservation::findOrFail($id);

        // Modifie le statut de la réservation et ajoute le motif de refus
        $reservation->status = 'rejected';
        $reservation->rejection_reason = $request->input('reason');
        $reservation->save();

        // Envoi de l'email avec le motif de refus
        Mail::to($reservation->client->email)->send(new ReservationStatusMail($reservation, 'rejected'));

        // Notification via toastr
        toastr()->error('Réservation refusée avec succès!', " ");

        // Redirection
        return redirect()->route('restaurant.reservations');
    }

    /**
     * Display a listing of the resource.
     */
    public function confirmed(Request $request)
    {

        $restaurant = Restaurant::find($request->id);
        return view('client.confirm', ['restaurant' => $restaurant]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function reservation()
    {
        //
        $restaurant = Auth::guard('restaurant')->user();
        $reservations = Reservation::with('client', 'table')
            ->whereHas('table', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })
            ->get();
        return view('restaurant.reservations', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valider les données du formulaire
        $validatedData = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'required|exists:tables,id',
            'reservation_date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
            'reservation_time' => 'required|string',
            'guest_number' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:500',
        ]);

        // Vérifier si la table est disponible à cette date et heure
        $existingReservation = Reservation::where('table_id', $validatedData['table_id'])
            ->where('reservation_date', $validatedData['reservation_date'])
            ->where('reservation_time', $validatedData['reservation_time'])
            ->exists();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'Cette table est déjà réservée à cette date et heure. Veuillez choisir une autre table ou un autre horaire.');
        }

        // Vérifier si la capacité de la table est suffisante
        $table = Table::findOrFail($validatedData['table_id']);
        if ($table->capacity < $validatedData['guest_number']) {
            return redirect()->back()->with('error', 'La capacité de cette table est insuffisante pour le nombre de personnes spécifié.');
        }

        // Créer la réservation
        $reservation = new Reservation();
        $reservation->client_id = Auth::id(); // Supposons que l'utilisateur est connecté
        $reservation->table_id = $validatedData['table_id'];
        $reservation->reservation_date = $validatedData['reservation_date'];
        $reservation->reservation_time = $validatedData['reservation_time'];
        $reservation->guest_number = $validatedData['guest_number'];
        $reservation->special_requests = $validatedData['special_requests'];
        $reservation->status = 'pending'; // Statut par défaut
        $reservation->save();

        // Rediriger vers la page de confirmation
        return redirect()->route('restaurant.confirmation', $reservation->id)
            ->with('success', 'Votre réservation a été enregistrée avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reservation = Reservation::with(['table.restaurant'])->findOrFail($id);
        
        if (Auth::id() != $reservation->client_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('client.reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Request $request)
    {

        $table = Table::findOrFail($request->table_id);
        // $table->status = "Disponible";
        $table->save();

        $restaurant = Restaurant::findOrFail($request->restaurant_id);
        $client = Client::findOrFail($request->client_id);
        $client->yums = $client->yums - $restaurant->yums;
        $client->save();

        $reservation = Reservation::findOrFail($request->id);
        $reservation->delete();
        toastr()->error('La reservation a été bien supprimé !', " ");
        return redirect()->route("client.reservations");
    }

    public function confirmation($id)
    {
        $reservation = Reservation::with('restaurant')->findOrFail($id);
        $restaurant = $reservation->restaurant;

        return view('client.confirm', compact('reservation', 'restaurant'));
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class); // Une réservation appartient à un restaurant
    }

    public function checkTableAvailability(Request $request)
{
    $date = $request->query('date');
    $time = $request->query('time');

    $reservedTables = Reservation::where('date', $date)
        ->where('time', $time)
        ->pluck('table_id')
        ->toArray();

    return response()->json(['reservedTables' => $reservedTables]);
}

public function showAvailableTables(Request $request)
{
    $request->validate([
        'restaurant_id' => 'required|integer',
        'date' => 'required|date',
        'time' => 'required|string',
    ]);
    
    $restaurantId = $request->restaurant_id;
    $date = $request->date;
    $time = $request->time;
    
    // Récupérer toutes les tables du restaurant
    $tables = Table::where('restaurant_id', $restaurantId)->get();
    
    // Récupérer les tables déjà réservées à cette date et heure
    $reservedTableIds = Reservation::where('reservation_date', $date)
                               ->where('reservation_time', $time)
                               ->pluck('table_id')
                               ->toArray();
    
    return response()->json([
        'tables' => $tables,
        'reservées' => $reservedTableIds
    ]);
}

}
