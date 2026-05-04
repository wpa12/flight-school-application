<?php

namespace Database\Factories;

use App\Models\Airport;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Address;

/**
 * @extends Factory<Airport>
 */
class AirportFactory extends Factory
{
        /**
     * UK airports used for demos and seeding. ICAO codes must be unique (see airports.icao_code).
     *
     * @return array<string, string>
     */
    public static function ukAirportCatalog(): array
    {
        return [
            'London Luton Airport' => 'EGGW',
            'London Heathrow Airport' => 'EGLL',
            'London Gatwick Airport' => 'EGKK',
            'London Stansted Airport' => 'EGSS',
            'London City Airport' => 'EGLC',
            'London Southend Airport' => 'EGMC',
            'Bristol Airport' => 'EGGD',
            'Manchester Airport' => 'EGCC',
            'Leeds Bradford Airport' => 'EGNM',
            'Newcastle Airport' => 'EGNT',
            'Sheffield Airport' => 'EGNY',
            'Liverpool John Lennon Airport' => 'EGGP',
            'East Midlands Airport' => 'EGNX',
            'Nottingham Airport' => 'EGBN',
            'Birmingham Airport' => 'EGBB',
            'Coventry Airport' => 'EGBE',
            'Leicester Airport' => 'EGBG',
            'Gloucestershire Airport' => 'EGBJ',
        ];
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $airports = self::ukAirportCatalog();
        $airportByName = fake()->randomElement(array_keys($airports));
        $airportByIcao = $airports[$airportByName];

        return [
            'name' => $airportByName, // name of airport
            'icao_code' => $airportByIcao, // ICAO code of the airport
            'address_id' => Address::factory()->create()->id, // address of the airport
            'avgas_price_per_litre' => fake()->randomFloat(2, 1, 2.5), // Avgas fuel price
            'jetA1_price_per_litre' => fake()->randomFloat(2, 0.70, 2), // JetA1 fuel price
            'landing_fee' => fake()->randomFloat(2, 5, 20), // landing fees at each airport
        ];
    }
}
