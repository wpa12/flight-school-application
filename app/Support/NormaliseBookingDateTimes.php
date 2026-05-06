<?php

declare(strict_types=1);

namespace App\Support;

use App\Models\Exam;
use Carbon\Carbon;
use App\Enums\BookableType;

class NormaliseBookingDateTimes
{
    public static function normaliseExamBookingDateTimes(string $bookableType, array $data): array
    {
        $startDateTime = null;
        $endDateTime = null;

        [$startDateTime, $endDateTime] = match ($bookableType) {
            BookableType::EXAM->value => [
                Carbon::parse("{$data['start_date']} {$data['start_time']}"),
                Carbon::parse("{$data['start_date']} {$data['start_time']}")
                    ->addMinutes(Exam::find($data['bookable_id'])->duration_minutes),
            ],
            BookableType::AIRCRAFT->value,
            BookableType::LESSON->value => self::aircraftOrLessonRange($data),
            default => [null, null],
        }; // all this does is destructure the arrays returned into the $startDateTime and $endDateTime variables

        return [
            'booking_date_time_start' => $startDateTime,
            'booking_date_time_end' => $endDateTime,
        ];
    }

    private static function aircraftOrLessonRange(array $data): array
    {
        $start = Carbon::parse("{$data['start_date']} {$data['start_time']}");
        $hours = (float) ($data['duration_hours'] ?? 0);

        return [
            $start,
            $start->copy()->addHours($hours),
        ];
    }

}
