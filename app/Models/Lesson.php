<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\BookableContract;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['aircraft_id', 'instructor_id', 'user_id', 'lesson_date_time_start', 'lesson_date_time_end', 'total_price', 'lesson_status'])]
class Lesson extends Model implements BookableContract
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
