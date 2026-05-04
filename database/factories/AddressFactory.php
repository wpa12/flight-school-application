<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'address_line_1' => fake()->streetAddress(),
            'address_line_2' => fake()->secondaryAddress(),
            'city' => fake()->city(),
            'postal_code' => fake()->postcode(),
            'country' => 'United Kingdom',
        ];
    }
}
