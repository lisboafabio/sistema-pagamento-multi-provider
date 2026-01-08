<?php

namespace App\Providers;

use App\Events\AuthorizedPaymentEvent;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class CustomEventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Event::listen(
            AuthorizedPaymentEvent::class
        );
    }
}
