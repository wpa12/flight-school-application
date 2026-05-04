<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

/**
 * @extends Factory<Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(self::examTypesCatalog()),
            'description' => fake()->sentence(),
            'total_price' => fake()->numberBetween(2, 100, 250),
        ];
    }

    public static function examTypesCatalog(): array
    {
        return [
            'Airlaw',
            'Navigation',
            'Meteorology',
            'Principles of Flight',
            'Instrumentation',
            'Aerodynamics',
            'Performance',
            'Airplane Performance',
            'CFI Theory',
            'ATPL Theory',
        ];
    }
}
