<?php

namespace Database\Factories;

use App\Models\Wilaya;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Commune>
 */
class CommuneFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wilaya_id' => Wilaya::factory(),
            'geoalgeria_id' => fake()->unique()->numberBetween(1, 999999),
            'name' => fake()->city(),
            'name_ar' => null,
            'daira_name' => fake()->city(),
            'postal_code' => fake()->postcode(),
        ];
    }
}
