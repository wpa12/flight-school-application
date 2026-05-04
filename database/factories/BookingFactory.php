<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Aircraft;
use App\Models\Exam;
use App\Models\Lesson;
use Carbon\Carbon;
use App\Models\Instructor;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Bookable types array for seeding
     */
    public static function bookableTypes(): array
    {
        return [
            Aircraft::class,
            Exam::class,
            Lesson::class,
        ];
    }

    /**
     * Generate a random booking date in the past or future based on random number gen
     */
    public static function generateBookingDate(): string
    {
        $decideDateInFutureOrPast = rand(0, 1);

        return match ($decideDateInFutureOrPast) {
            0 => Carbon::now()->subDays(fake()->numberBetween(1, 25))->format('Y-m-d'),
            1 => Carbon::now()->addDays(fake()->numberBetween(1, 25))->format('Y-m-d'),
        };
    }

    /**
     * Generate the booking times for the booking
     */
    public static function generateBookingTimes(): array
    {

        $timeblock = self::halfHourBlock(); // just added this to ensure no silly times other than on the hour or half past the hour can be generated
        $bookingDurationHours = self::generateBookingDuration(); // this is to ensure the booking duration is a realistic duration

        // lets assume that you can't book an aircraft out after 8am or after 11pm because the next hour is technically a next day
        $timeStart = Carbon::now()->setTime(rand(8, 23), $timeblock)->addDays(rand(-25, 25)); // this is to ensure the time out is a realistic time
        $timeEnd = $timeStart->copy()->addHours($bookingDurationHours)->setMinutes($timeblock); // this is to ensure the time in is a realistic time, you could book a flight at 11pm then do a night flight and come back at 3am the next day

        return [
            'booking_date_time_start' => $timeStart,
            'booking_date_time_end' => $timeEnd,
        ];
    }

    /**
     * Generate the booking duration for the booking
     */
    private static function generateBookingDuration(): int
    {
        return rand(1, 24);
    }

    /**
     * Generate the half hour block for the booking
     */
    private static function halfHourBlock(): int
    {
        return rand(0, 1) * 30; // i've added this to ensure the booking duration is a realistic one of half hour increments
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bookableTypes = fake()->randomElement(self::bookableTypes());

        return [
            'bookable_id' => fake()->numberBetween(1, 10),
            'bookable_type' => $bookableTypes,
            'user_id' => fake()->numberBetween(1, 10),
            'instructor_id' => $bookableTypes === Lesson::class ? Instructor::query()->pluck('id')->random() : null,
            'booking_date_time_start' => fake()->dateTime(),
            'booking_date_time_end' => fake()->dateTime(),
        ];
    }
}
