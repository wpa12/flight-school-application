<?php

namespace Database\Factories;

use App\Models\EngineType;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FuelType;

/**
 * @extends Factory<EngineType>
 */
class EngineTypeFactory extends Factory
{
    /**
     * Engine types array for seeding
     *
     * @return array
     */
    public static function engineTypeCatalog(): array
    {
        return [
            'single' => 'single piston engine',
            'multi' => 'multi piston engine',
            'jet' => 'jet engine',
            'twinjet' => 'twinjet engine',
            'turboprop' => 'turboprop engine',
            'twinturboprop' => 'twin-turboprop engine',
        ];
    }


    /**
     * Fuel type for a catalog engine type
     *
     * @param string $engineType
     * @return string
     */
    public static function fuelTypeSlugFor(string $engineType): string
    {
        return match ($engineType) {
            'single', 'multi' => 'avgas',
            default => 'jetA1',
        };
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $engineTypes = self::engineTypeCatalog();
        $engineType = fake()->unique()->randomElement(array_keys($engineTypes));
        $fuelSlug = self::fuelTypeSlugFor($engineType);

        return [
            'type' => $engineType,
            'description' => $engineTypes[$engineType],
            'fuel_type_id' => FuelType::query()->where('type', $fuelSlug)->first()->id,
        ];
    }
}
