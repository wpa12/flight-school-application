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

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable'); // this is the relationship to the bookings table
    }
}
