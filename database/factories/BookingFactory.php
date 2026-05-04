<?php

namespace Database\Factories;

use App\Models\Aircraft;
use App\Models\Booking;
use App\Models\Exam;
use App\Models\Instructor;
use App\Models\Lesson;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @return array<int, class-string>
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
     * This function is used to get the duration in minutes for the bookable type
     * @param string $bookableType
     * @return int
     */
    private static function durationMinutesForBookable(string $bookableType): int
    {
        return match ($bookableType) {
            Lesson::class => fake()->numberBetween(1, 6) * 30, // Lessons can last a minimum of 30 mins or max 3 hours
            Exam::class => fake()->numberBetween(1, 4) * 15, // exams can last a minimum of 15mins or max 1 hour
            Aircraft::class => fake()->numberBetween(1, 48) * 30, // aircraft can be booked for minimum of 30mins or for maximum of 24 hours
            default => fake()->numberBetween(1, 8) * 30, // default is 1-8 hours
        };
    }

    private static function halfHourBlock(): int
    {
        return fake()->randomElement([0, 30]);
    }

    /**
     * @return array
     */
    public static function generateBookingTimes(string $bookableType): array
    {
        $durationMinutes = self::durationMinutesForBookable($bookableType); // throws in the bookable type and returns a duration in minutes

        $timeStart = Carbon::now()
            ->startOfDay()
            ->addDays(fake()->numberBetween(-25, 25))
            ->setTime(
                fake()->numberBetween(6, 20),
                self::halfHourBlock()
            );

        $timeEnd = $timeStart->copy()->addMinutes($durationMinutes);

        if ($timeEnd <= $timeStart) {
            $timeEnd = $timeStart->copy()->addMinutes(max(30, $durationMinutes));
        }

        return [
            'booking_date_time_start' => $timeStart,
            'booking_date_time_end' => $timeEnd,
        ];
    }

    public function definition(): array
    {
        $bookableType = fake()->randomElement(self::bookableTypes());
        $times = self::generateBookingTimes($bookableType);

        return [
            'bookable_id' => fake()->numberBetween(1, 10),
            'bookable_type' => $bookableType,
            'user_id' => fake()->numberBetween(1, 10),
            'instructor_id' => $bookableType === Lesson::class ? Instructor::query()->pluck('id')->random() : null,
            'booking_date_time_start' => $times['booking_date_time_start'],
            'booking_date_time_end' => $times['booking_date_time_end'],
        ];
    }
}