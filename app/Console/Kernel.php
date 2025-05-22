<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        // Exécuter la commande tous les jours à 6h du matin
        $schedule->command('reservations:mark-honored')
                 ->dailyAt('06:00')
                 ->appendOutputTo(storage_path('logs/scheduler.log'));
                 
        // Alternative : exécuter toutes les heures pendant les heures d'ouverture
         $schedule->command('reservations:mark-honored')
                  ->hourly()
                  ->between('08:00', '23:00')
                  ->appendOutputTo(storage_path('logs/scheduler.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
