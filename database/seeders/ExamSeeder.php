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
        foreach (ExamFactory::examTypesCatalog() as $examType) {
            Exam::factory()->create([
                'type' => $examType,
                'description' => fake()->sentence(),
                'total_price' => fake()->numberBetween(2, 100, 250),
            ]);
        }

    }
}
