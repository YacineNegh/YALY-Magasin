<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Wilaya>
 */
class WilayaFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->numberBetween(1, 69),
            'name' => fake()->city(),
            'name_ar' => null,
            'delivery_price' => fake()->numberBetween(400, 1400),
            'is_delivery_available' => true,
        ];
    }
}
