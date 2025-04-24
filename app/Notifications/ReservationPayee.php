<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Reservation;

class ReservationPayee extends Notification implements ShouldQueue
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
     * Détermine les canaux de livraison.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Représentation de l'email.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nouvelle commande payée')
            ->line("Le client **{$this->reservation->client->name}** a payé une commande.")
            ->line("Date de la réservation : **" . $this->reservation->reservation_date->format('d/m/Y à H:i') . "**")
            ->line("Merci de préparer la commande à temps.")
            ->action('Voir la commande', route('restaurant.reservations.show', $this->reservation->id));
    }

    /**
     * Représentation sous forme de tableau.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'reservation_id' => $this->reservation->id,
            'client_name' => $this->reservation->client->name,
            'status' => 'payée',
        ];
    }
}
