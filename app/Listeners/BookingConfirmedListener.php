<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\BookingConfirmationNotification;
use Illuminate\Support\Facades\Notification;

class BookingConfirmedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Notification::send($event->booking->user, new BookingConfirmationNotification($event->booking));
    }
}
