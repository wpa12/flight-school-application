<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EngineType;
use Database\Factories\EngineTypeFactory;
use App\Models\FuelType;

class EngineTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (EngineTypeFactory::engineTypeCatalog() as $type => $description) {
            $fuelSlug = EngineTypeFactory::fuelTypeSlugFor($type); // get the fuel_type_id for the engine type

            EngineType::factory()->create([
                'type' => $type,
                'description' => $description,
                'fuel_type_id' => FuelType::query()->where('type', $fuelSlug)->first()->id,
            ]);
        }
    }
}
