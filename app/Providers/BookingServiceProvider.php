<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\BookingService;
use App\Repositories\BookingRepository;
use Illuminate\Support\Facades\Event;
use App\Events\BookingConfirmed;
use App\Listeners\BookingConfirmedListener;
use App\Events\BookingUpdated;
use App\Listeners\BookingUpdatedListener;
use App\Events\BookingCancelled;
use App\Listeners\BookingCancelledListener;
use App\Services\PaymentService;

class BookingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BookingService::class, function ($app) {
            return new BookingService($app->make(BookingRepository::class), $app->make(PaymentService::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // event listeners for the booking events
        Event::listen(BookingConfirmed::class, BookingConfirmedListener::class);
        Event::listen(BookingUpdated::class, BookingUpdatedListener::class);
        Event::listen(BookingCancelled::class, BookingCancelledListener::class);
    }
}
