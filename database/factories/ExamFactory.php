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
        $exams = self::examTypesCatalogAndPrices();
        $price = fake()->randomElement(array_values($exams));
        $examType = fake()->randomElement(array_keys($exams));

        return [
            'type' => $examType,
            'description' => fake()->sentence(),
            'duration_minutes' => fake()->randomElement([60, 90, 120]), // 1, 1.5 or 2 hours
            'total_price' => $price,
        ];
    }

    public static function examTypesCatalogAndPrices(): array
    {
        return [
            'Airlaw' => 50,
            'Navigation' => 50,
            'Meteorology' => 50,
            'Principles of Flight' => 50,
            'Instrument flight rules' => 100,
            'Aerodynamics' => 50,
            'Performance' => 50,
            'Airplane Performance' => 50,
            'CFI Theory' => 100,
            'ATPL Theory' => 100,
        ];
    }
}
