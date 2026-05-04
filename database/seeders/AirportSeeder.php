<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Airport;
use Database\Factories\AirportFactory;

class AirportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (AirportFactory::ukAirportCatalog() as $name => $icaoCode) {
            Airport::factory()->create([
                'name' => $name,
                'icao_code' => $icaoCode,
            ]);
        }
    }
}
