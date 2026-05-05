<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\BookableContract;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['type', 'exam_date_time', 'exam_date_time_end', 'total_price'])]
class Exam extends Model implements BookableContract
{
    /** @use HasFactory<\Database\Factories\ExamFactory> */
    use HasFactory;

    /**
     * deletes the bookings when an exam is deleted to avoid orphaned bookings
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::deleting(function (Exam $exam) {
            $exam->bookings()->delete();
        });
    }

    /**
     * polymorphic relationship to the bookings table
     *
     * @return MorphMany
     */
    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable'); // this is the relationship to the bookings table
    }
}
