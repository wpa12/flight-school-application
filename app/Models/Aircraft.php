<?php

namespace App\Models;

use App\Contracts\BookableContract;
use Database\Factories\AircraftFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

#[Fillable(['type', 'make', 'model', 'description', 'registration', 'engine_type_id', 'rental_price_per_hour', 'in_service', 'current_hours', 'image_url'])]
class Aircraft extends Model implements BookableContract
{
    /** @use HasFactory<AircraftFactory> */
    use HasFactory;

    protected $casts = [
        'in_service' => 'boolean',
    ];

    /**
     * deletes the bookign when an aircraft is deleted
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::deleting(function (Aircraft $aircraft) {
            $aircraft->bookings()->delete();
        });
    }

    /**
     * polymorphic relationship to the bookings table
     */
    public function bookings(): MorphMany
    {
        return $this->morphMany(Booking::class, 'bookable');
    }

    /**
     * Engine type relationship
     */
    public function engineType(): BelongsTo
    {
        return $this->belongsTo(EngineType::class);
    }

    /**
     * fuel Type relationship
     */
    public function fuelType(): HasOneThrough
    {
        return $this->hasOneThrough(FuelType::class, EngineType::class, 'id', 'id', 'engine_type_id', 'fuel_type_id');
    }

    /**
     * Scope to get serviceable aircraft
     */
    public function scopeIsServiceable(Builder $query): Builder
    {
        return $query->where('in_service', true);
    }

    /**
     * Mark the aircraft as serviceable
     */
    public function markAsServiceable(): void
    {
        $this->in_service = true;
    }

    /**
     * Mark the aircraft as unserviceable
     */
    public function markAsUnserviceable(): void
    {
        $this->in_service = false;
    }

    /**
     * relationship to the lessons table
     *
     * @return HasMany
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }
}
