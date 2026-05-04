<?php

namespace Database\Factories;

use App\Models\Aircraft;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\EngineType;

/**
 * @extends Factory<Aircraft>
 */
class AircraftFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        ['make' => $make, 'type' => $type, 'model' => $model] = $this->randomMakeClassificationAndModel(); // just destructuring the array to get the make, type and model

        $rate = match ($type) {
            'single' => [85, 150],
            'multi' => [150, 200],
            'jet' => [200, 300],
            'twinjet' => [500, 100],
            'turboprop' => [300, 500],
            'twinturboprop' => [500, 1000],
        }; // this assigns an hourly rate conducive of the type of aircraft hired.

        $engineType = EngineType::query()->where('type', $type)->first()->id; // get the engine type id for the aircraft

        return [
            'type' => $type,
            'make' => $make,
            'model' => $model,
            'description' => fake()->sentence(), // this is just a sentence to say what the aircraft is used for etc...
            'registration' => fake()->unique()->regexify($this->generateRegistrationCodeFormat()), // this si just generating a random registration code the aircraft
            'rental_price_per_hour' => fake()->randomFloat(2, $rate[0], $rate[1]), // this is just a random price to say how much the aircraft is rented for per hour
            'engine_type_id' => $engineType,
            'in_service' => fake()->boolean(), // this is just a boolean to say if the aircraft is in service or not
            'current_hours' => fake()->numberBetween(0, 20000), // this is just a number to say how many hours the aircraft has flown
        ];
    }


    /**
     * Pick make, DB type [single, multi, jet], and model from nested structure.
     *
     * @return array{make: string, type: string, model: string}
     */
    private function randomMakeClassificationAndModel(): array
    {
        $byMake = $this->aircraftTypes();
        $make = fake()->randomElement(array_keys($byMake)); // this is just getting a random make from the array

        $classifications = array_values(array_filter(
            ['single', 'multi', 'jet', 'twinjet', 'turboprop', 'twinturboprop'],
            fn (string $key): bool => ($byMake[$make][$key] ?? []) !== []
        ));

        if ($classifications === []) {
            return $this->randomMakeClassificationAndModel();
        }

        $type = fake()->randomElement($classifications);

        return [
            'make' => $make,
            'type' => $type,
            'model' => fake()->randomElement($byMake[$make][$type]),
        ];
    }

    /**
     * Generate a random registration code format based on random number
     */
    private function generateRegistrationCodeFormat(): string
    {
        $rand = rand(0, 100); // increases probability of uk aircraft registration codes

        return match ($rand) {
            0 => '[A-Z]{1,2}-[A-Z0-9]{2,5}', // this one is for european aircraft registration
            1 => 'N[0-9]{1,5}[A-Z]{0,2}', // this one is for american aircraft registration codes
            default => 'G-[A-Z]{4}', // this one is for UK aircraft
        };
    }

    /**
     * Aircraft models grouped by make and engine class [single, multi, jet]
     *
     * @return array<string, array<string, list<string>>>
     */
    private function aircraftTypes(): array
    {
        return [
            'Cessna' => [
                'single' => ['172 Skyhawk', '182 Skylane', '206 Stationair'],
                'multi' => ['310', '340', '421'],
                'jet' => [],
                'twinjet' => ['Citation CJ3', 'Citation XLS', 'Citation X'],
                'turboprop' => ['208 Caravan', '208B Grand Caravan EX'],
                'twinturboprop' => ['441 Conquest II', '425 Conquest I', '408 SkyCourier'],
            ],
            'Piper' => [
                'single' => ['PA-28 Cherokee', 'PA-32 Saratoga', 'PA-46 Malibu'],
                'multi' => ['PA-34 Seneca', 'PA-44 Seminole'],
                'jet' => [],
                'twinjet' => [],
                'turboprop' => [],
                'twinturboprop' => [],
            ],
            'Beechcraft' => [
                'single' => ['Bonanza G36'],
                'multi' => ['Baron G58', 'Duchess 76'],
                'jet' => [],
                'twinjet' => ['Premier I', 'Hawker 400XP'],
                'turboprop' => ['Beechcraft Denali'],
                'twinturboprop' => [
                    'King Air 90',
                    'King Air 200',
                    'King Air 260',
                    'King Air 350',
                    'King Air 360',
                    'Beechcraft 1900',
                    'Starship 2000'
                ],
            ],
            'Diamond' => [
                'single' => ['DA20 Katana', 'DA40 Diamond Star', 'DA50 RG'],
                'multi' => ['DA42 Twin Star', 'DA62'],
                'jet' => [],
                'twinjet' => [],
                'turboprop' => [],
                'twinturboprop' => ['DA42-VI'],
            ],
            'Cirrus' => [
                'single' => ['SR20', 'SR22', 'SR22T'],
                'multi' => [],
                'jet' => ['Vision Jet SF50', 'Vision Jet SF50i'],
                'twinjet' => [],
                'turboprop' => [],
                'twinturboprop' => [],
            ],
        ];
    }
}
