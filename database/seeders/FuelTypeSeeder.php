<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FuelType;
use Database\Factories\FuelTypeFactory;

class FuelTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (FuelTypeFactory::fuelTypeCatalog() as $type => $description) {
            FuelType::factory()->create([
                'type' => $type,
                'description' => $description,
            ]);
        }
    }
}
