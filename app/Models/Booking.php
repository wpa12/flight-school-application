<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[Fillable(['bookable_id', 'bookable_type', 'user_id', 'instructor_id', 'booking_date_time_start', 'booking_date_time_end', 'total_price', 'booking_status'])]
class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'booking_date_time_start' => 'datetime',
            'booking_date_time_end' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(Instructor::class);
    }

    public function bookable(): MorphTo
    {
        return $this->morphTo();
    }

    public function bookableSummary(): string
    {
        $bookable = $this->bookable;

        if ($bookable === null) {
            return '—';
        }

        return match (true) {
            $bookable instanceof Aircraft => $bookable->registration . ': ' . $bookable->make . ' ' .$bookable->model,
            $bookable instanceof Exam => 'Exam:  ' . ($bookable->type ?? 'session'),
            $bookable instanceof Lesson => 'Lesson: ' . ($bookable->aircraft->registration ?? 'session'),
            default => class_basename($this->bookable_type ?? ''),
        };
    }

    public function instructorDisplayName(): ?string
    {
        if ($this->instructor === null) {
            return null;
        }

        return trim($this->instructor->first_name.' '.$this->instructor->last_name) ?: null;
    }
}
