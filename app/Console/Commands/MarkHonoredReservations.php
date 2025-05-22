<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use Carbon\Carbon;

class MarkHonoredReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:mark-honored';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marquer automatiquement les réservations confirmées passées comme honorées';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Vérification des réservations à marquer comme honorées...');
        
        // Marquer comme honorées toutes les réservations confirmées dont la date est passée
        $yesterday = Carbon::yesterday()->toDateString();
        
        $reservationsToUpdate = Reservation::where('status', 'confirmed')
            ->where('reservation_date', '<=', $yesterday)
            ->get();
            
        $count = $reservationsToUpdate->count();
        
        if ($count > 0) {
            Reservation::where('status', 'confirmed')
                ->where('reservation_date', '<=', $yesterday)
                ->update(['status' => 'honored']);
                
            $this->info("✅ $count réservation(s) marquée(s) comme honorée(s).");
            
            // Afficher les détails si demandé
            if ($this->option('verbose')) {
                $this->table(
                    ['ID', 'Client', 'Restaurant', 'Date', 'Ancien Status', 'Nouveau Status'],
                    $reservationsToUpdate->map(function ($reservation) {
                        return [
                            $reservation->id,
                            $reservation->client->name ?? 'N/A',
                            $reservation->table->restaurant->name ?? 'N/A',
                            $reservation->reservation_date,
                            'confirmed',
                            'honored'
                        ];
                    })->toArray()
                );
            }
        } else {
            $this->info('ℹ️  Aucune réservation à marquer comme honorée.');
        }
        
        return Command::SUCCESS;
    }
}