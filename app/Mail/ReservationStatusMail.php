<?php
namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $status;

    public function __construct(Reservation $reservation, $status)
    {
        $this->reservation = $reservation;
        $this->status = $status;
    }

    public function build()
    {
        $subject = $this->status == 'approved' ? 'Votre réservation est confirmée' : 'Votre réservation a été refusée';

        return $this->subject($subject)
                    ->view('emails.reservations')
                    ->with([
                        'reservation' => $this->reservation,
                        'status' => $this->status,
                        'reason' => $this->status == 'rejected' ? $this->reservation->rejection_reason : null
                    ]);
    }
}
