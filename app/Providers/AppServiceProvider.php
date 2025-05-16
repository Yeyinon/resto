<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Restaurant;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partager la variable $locations avec toutes les vues qui utilisent le template master
        View::composer('master', function ($view) {
            // Récupérer toutes les locations uniques des restaurants
            $locations = Restaurant::distinct('location')->pluck('location')->toArray();
            
            // Partager la variable avec la vue
            $view->with('locations', $locations);
        });
    }
}
