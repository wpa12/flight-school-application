<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookingRepository
{
    public function __construct(private Booking $booking)
    {}

    /**
     * check for overlapping bookings with the instructor and bookable type
     *
     * @param Booking $booking
     * @return boolean
     */
    public function checkForOverlappingBookingsWithInstructorAndBookable(Booking $booking): bool
    {
        return $this->booking->query()
        ->with(['bookable', 'bookable.instructor'])
        ->where('booking_date_time_start', '<=', $booking->booking_date_time_end)
        ->where('booking_date_time_end', '>=', $booking->booking_date_time_start)
        ->where('id', '!=', $booking->id)
        ->where('booking_status', 'confirmed')
        ->where(function ($query) {
            $query->instructor()
                ->where('instructor_id', $this->booking->instructor?->id)
                ->orWhere('instructor_id', null);
            $query->bookable()->where('bookable_id', $this->booking->bookable?->id)
                ->orWhere('bookable_id', null);
        })
        ->exists(); // beasty query to check if the bookkable type and the instructor are overlapping with another booking i.e. could be already booked for another flight
    }

    /**
     * Get all confirmed bookings that are due to start in the next 24 hours
     *
     * @return Collection
     */
    public function getBookingsForReminders(): Collection
    {
        return $this->booking
        ->where('booking_date_time_start', '>=', now())
        ->where('booking_date_time_start', '<', now()->addHours(24))
        ->where('reminder_sent', false)
        ->where('booking_status', 'confirmed')
        ->with(['user'])
        ->get();
    }

    /**
     * Update the reminder sent status for a list of bookings that have been sent a reminder
     *
     * @param array $bookingIds
     * @return void
     */
    public function updateBookingReminderSentFlag(array $bookingIds): void
    {
        DB::transaction(function () use ($bookingIds) {
            $this->booking->whereIn('id', $bookingIds)->update(['reminder_sent' => true]);
        });
    }

    /**
     * Create a booking against a bookable
     *
     * @param string $bookableType
     * @param int $bookableId
     * @param array $data
     * @return Booking
     */
    public function createBooking(string $bookableType, int $bookableId, array $data): Booking
    {
        return $this->booking->create([
            ...$data,
            'bookable_type' => $bookableType,
            'bookable_id' => $bookableId,
        ]);
    }
}
