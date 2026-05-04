<?php

namespace Database\Factories;

use App\Models\FuelType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FuelType>
 */
class FuelTypeFactory extends Factory
{

    /**
     * Fuel types array for seeding
     *
     * @return array
     */
    public static function fuelTypeCatalog(): array
    {
        return [
            'avgas' => 'Aviation gasoline',
            'jetA1' => 'Jet A-1',
        ];
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fuelTypes = self::fuelTypeCatalog();
        $fuelType = fake()->unique()->randomElement(array_keys($fuelTypes));

        return [
            'type' => $fuelType,
            'description' => $fuelTypes[$fuelType],
        ];
    }
}
