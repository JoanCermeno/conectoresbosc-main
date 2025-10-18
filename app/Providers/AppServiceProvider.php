<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        //// Verifica si la aplicación está en un entorno de producción (o similar)
        // y si la variable de entorno APP_ENV es 'production'.
        if (config('app.env') === 'production' || env('APP_ENV') === 'production') {
            // Esto le dice a Laravel que genere todos los URLs (incluyendo los de assets)
            // usando el esquema HTTPS.
            URL::forceScheme('https');
        }
    }
}
