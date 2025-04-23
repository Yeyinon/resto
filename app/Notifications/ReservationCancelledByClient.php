<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use \App\Models\Reservation;
use Carbon\Carbon;

class ReservationCancelledByClient extends Notification
{
    use Queueable;

    protected $reservation;

    /**
     * Crée une nouvelle instance de notification.
     *
     * @param  \App\Models\Reservation  $reservation
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }


    /**
     * Obtenez les canaux de livraison de la notification.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Obtenez la représentation de l'email de la notification.
     */
    public function toMail($notifiable)
{
    // Vérifie si reservation_date est déjà un objet Carbon, sinon on le transforme
    $formattedDate = Carbon::parse($this->reservation->reservation_date)->format('d/m/Y à H:i');

    return (new MailMessage)
        ->subject('Une réservation a été annulée')
        ->line("Le client {$this->reservation->client->name} a annulé sa réservation prévue le {$formattedDate}.")
        ->line('Merci de mettre à jour vos disponibilités.')
        ->action('Voir la réservation', route('reservation.cancel', ['id' => $this->reservation->id]));  // Assurez-vous que la route est correctement appelée
}



    /**
     * Obtenez la représentation sous forme de tableau de la notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'reservation_id' => $this->reservation->id,
            'client_id' => $this->reservation->client->id,
            'status' => 'cancelled',
        ];
    }
}
