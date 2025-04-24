<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Notifications\ReservationPayee;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();

        // On récupère l’ID de la réservation depuis les données personnalisées envoyées à FedaPay
        $reservationId = $payload['data']['transaction']['custom_data']['reservation_id'] ?? null;

        if (!$reservationId) {
            return response()->json(['message' => 'ID de réservation introuvable'], 400);
        }

        $reservation = Reservation::find($reservationId);

        if (!$reservation) {
            return response()->json(['message' => 'Réservation non trouvée'], 404);
        }

        // Marquer la réservation comme payée
        $reservation->is_paid = true;
        $reservation->save();

        // Notifier le restaurant
        $restaurant = $reservation->restaurant;
        if ($restaurant && $restaurant->email) {
            $restaurant->notify(new ReservationPayee($reservation));
        }

        return response()->json(['message' => 'Notification traitée avec succès'], 200);
    }
}
