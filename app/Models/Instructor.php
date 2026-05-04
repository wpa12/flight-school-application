<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['image_url', 'first_name', 'last_name', 'email', 'phone'])]
class Instructor extends Model
{
    /** @use HasFactory<\Database\Factories\InstructorFactory> */
    use HasFactory;
}
