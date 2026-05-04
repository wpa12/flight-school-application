<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Contracts\BookableContract;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['type', 'make', 'model', 'description', 'registration', 'engine_type_id', 'rental_price_per_hour', 'in_service', 'current_hours', 'image_url'])]
class Aircraft extends Model implements BookableContract
{
    /** @use HasFactory<\Database\Factories\AircraftFactory> */
    use HasFactory;

    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }
}
