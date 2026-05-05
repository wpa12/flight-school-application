<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Exam;
use Database\Factories\ExamFactory;

class ExamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (ExamFactory::examTypesCatalogAndPrices() as $examType => $price) {
            Exam::factory()->create([
                'type' => $examType,
                'description' => fake()->sentence(),
                'duration_minutes' => fake()->randomElement([60, 90, 120]), // 1, 1.5 or 2 hours
                'total_price' => $price,
            ]);
        }

    }
}
