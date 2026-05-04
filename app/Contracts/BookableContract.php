<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface BookableContract
{
    public function bookings(): MorphMany; // this is the relationship to the bookings table
}