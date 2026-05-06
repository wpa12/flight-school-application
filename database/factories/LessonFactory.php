<?php

namespace Database\Factories;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Aircraft;
use App\Models\Instructor;
use App\Models\User;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'aircraft_id' => Aircraft::query()->pluck('id')->random(),
            'instructor_id' => Instructor::query()->pluck('id')->random(),
            'user_id' => User::query()->pluck('id')->random(),
            'total_price' => fake()->randomFloat(2, 100, 1000),
        ];
    }
}
