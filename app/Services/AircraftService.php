<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\AircraftType;
use App\Models\EngineType;
use App\Models\Aircraft;
use App\Notifications\AircraftRemovedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use App\Models\Booking;

class AircraftService
{
    /**
     * Sets the engine type based on the aircraft type selected
     *
     * @param string $type
     * @return integer
     */
    public static function setAircraftEngineBasedOnType(string $type): int
    {
        return match($type) {
            AircraftType::SINGLE->value => EngineType::query()->where('type', 'single')->first()->id,
            AircraftType::MULTI->value => EngineType::query()->where('type', 'multi')->first()->id,
            AircraftType::JET->value => EngineType::query()->where('type', 'jet')->first()->id,
            AircraftType::TWINJET->value => EngineType::query()->where('type', 'twinjet')->first()->id,
            AircraftType::TURBOPROP->value => EngineType::query()->where('type', 'turboprop')->first()->id,
            AircraftType::TWINTURBOPROP->value => EngineType::query()->where('type', 'twinturboprop')->first()->id,
            default => throw new \InvalidArgumentException('Invalid aircraft type'),
        };
    }

    /**
     * Deletes the aircraft and the lessons associated with it
     *
     * @param Aircraft $aircraft
     * @return void
     */
    public function deleteAircraftAndLessons(Aircraft $aircraft): void
    {
        $this->aircraftRemovedFromFleetNotification($aircraft);
        
        DB::transaction(function () use ($aircraft) {
            $aircraft->lessons->each->delete(); // have to do this because deleting aircraft deletes the lesson from DB before the static::deleting() is triggered
            $aircraft->delete();
        });
    }

    /**
     * Sends a notification to the users who have bookings for the aircraft
     *
     * @param Aircraft $aircraft
     * @return void
     */
    private function aircraftRemovedFromFleetNotification(Aircraft $aircraft): void
    {
        $bookings = Booking::query()
            ->whereMorphedTo('bookable', [$aircraft, ...$aircraft->lessons])
            ->where('booking_date_time_start', '>=', now())
            ->where(function ($query) {
                return $query->where('booking_status', 'confirmed')
                    ->orWhere('booking_status', 'pending');
            })
            ->with(['user'])
            ->get();

        $aircraftReg = $aircraft->registration;
        
        $bookings->each(function ($booking) use ($aircraftReg) {
            Notification::send($booking->user, new AircraftRemovedNotification($aircraftReg));
        });

    }
}
