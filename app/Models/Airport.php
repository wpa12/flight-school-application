<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['name','description', 'icao_code', 'landing_fee', 'avgas_price_per_litre', 'jetA1_price_per_litre', 'address_id'])]
class Airport extends Model
{
    /** @use HasFactory<\Database\Factories\AirportFactory> */
    use HasFactory;
}
