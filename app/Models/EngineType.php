<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['type', 'description', 'fuel_type_id'])]
class EngineType extends Model
{
    /** @use HasFactory<\Database\Factories\EngineTypeFactory> */
    use HasFactory;
}
