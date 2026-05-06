<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Booking;
use App\Contracts\BookableContract;
use App\Notifications\BookingReminderNotification; // to be moved to job
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;
use App\Repositories\BookingRepository;
use App\Exceptions\BookingException;
use App\Enums\BookingStatus;
use App\Models\Aircraft;
use App\Models\Exam;
use App\Models\Lesson;
use App\Support\ResolveBookableType;
use App\Support\NormaliseBookingDateTimes;
use App\Enums\BookableType;
use App\Events\BookingConfirmed;
use App\Events\BookingUpdated;
use App\Events\BookingCancelled;

class BookingService
{
    public function __construct(
        private BookingRepository $bookingRepository,
        private readonly PaymentService $paymentService
    )
    {}
    
    /**
     * creates a booking with a Bookable type
     *
     * @param BookableContract $bookable
     * @param array $data
     * @return Booking
     */
    public function createBooking(string $bookableType, int $bookableId, array $data): Booking
    {
        $resolvedBookableType = ResolveBookableType::resolveBookableType($bookableType);
        $normalisedBookingDateTimes = NormaliseBookingDateTimes::normaliseExamBookingDateTimes($bookableType, $data);

        //start payment gateway - to complete
            // $payment = $this->paymentService->createPaymentIntent($data['total_price'], ['bookable_type' => $resolvedBookableType, 'user_id' => $data['user_id']]);
        //end payment gateway

        $bookingData = [
            ...$data,
            ...$normalisedBookingDateTimes,
            'bookable_type' => $resolvedBookableType,
            'bookable_id' => $bookableId,
            'booking_status' => BookingStatus::CONFIRMED->value,
        ];

        $booking = $this->bookingRepository->createBooking(
            $resolvedBookableType,
            $bookableId,
            $bookingData
        ); // create the booking

        event(new BookingConfirmed($booking));

        return $booking;
    }

    // update a booking
    public function updateBooking(Booking $booking, array $data): Booking
    {
        $bookableType = $this->getBookableType($booking);
        
        $data['bookable_id'] = $booking->bookable_id;
        
        if ($bookableType === BookableType::AIRCRAFT->value || $bookableType === BookableType::LESSON->value) {
            $originalDurationMinutes = $booking->booking_date_time_start->diffInMinutes($booking->booking_date_time_end);
            $data['duration_hours'] = $originalDurationMinutes / 60;
        }
        
        $normalised = NormaliseBookingDateTimes::normaliseExamBookingDateTimes($bookableType, $data);
        $payload = array_merge($data, $normalised);
        $payload = Arr::only($payload, $booking->getFillable());

        $booking->update($payload);

        event(new BookingUpdated($booking));

        return $booking->fresh();
    }

    /**
     * cancel a booking
     *
     * @param Booking $booking
     * @return void
     */
    public function cancelBooking(Booking $booking): void
    {
        if($booking->booking_status === BookingStatus::COMPLETED->value || $booking->booking_status === BookingStatus::CANCELLED->value) {
            throw new BookingException('Booking cannot be cancelled because it is already completed or cancelled');
        }

        $booking->update([
            'booking_status' => BookingStatus::CANCELLED->value,
        ]);

        event(new BookingCancelled($booking));
    }
    
    // This is for a job that will run every day to send booking reminders to users
    public function sendBookingReminders(): void
    {
        $bookingIdsToUpdate = [];

        $bookings = $this->bookingRepository->getBookingsForReminders();

        foreach($bookings as $booking) {
            $bookingIdsToUpdate[] = $booking->id;
        }

        $this->bookingRepository->updateBookingReminderSentFlag($bookingIdsToUpdate);
    }

    /**
     * send booking reminder notification to the user -- to be moved to a job
     *
     * @param Booking $booking
     * @return void
     */
    private function sendBookingReminderNotification(Booking $booking): void
    {
        Notification::send($booking->user, new BookingReminderNotification($booking));
    }

    public function getBookableType(Booking $booking): string
    {
        return match (true) {
            $booking->bookable instanceof Aircraft => 'aircraft',
            $booking->bookable instanceof Exam => 'exam',
            $booking->bookable instanceof Lesson => 'lesson',
            default => '',
        };
    }
}
