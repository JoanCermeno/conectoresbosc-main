<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// ¡NECESITAS ESTA LÍNEA!
use Illuminate\Support\Facades\URL; 

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
        if (config('app.env') === 'production') { 
            // Esta línea ahora funcionará porque 'URL' está importado.
            URL::forceScheme('https'); 
        }
    }
}