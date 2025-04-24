<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationStatusMail;

class ReservationController extends Controller
{
    public function pending(Request $request)
    {
        $restaurant = Restaurant::find($request->id);
        $reservations = Reservation::with('client', 'table')
            ->where('status', 'pending') // Afficher uniquement les réservations en attente
            ->whereHas('table', function ($query) use ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            })
            ->get();

        return view('restaurant.reservations', compact('reservations', 'restaurant'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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



}
