<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \Illuminate\Auth\Events\Login::class => [
            \App\Listeners\Login\RestoreCartItems::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        \App\Models\Cover::observe(\App\Observers\CoverObserver::class);
        \App\Models\Order::observe(\App\Observers\OrderObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\Variant::observe(\App\Observers\VariantObserver::class);
    }
}