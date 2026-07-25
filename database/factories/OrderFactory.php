<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $itemsTotal = fake()->randomFloat(2, 1200, 80000);
        $deliveryPrice = fake()->randomFloat(2, 400, 1400);

        return [
            'order_number' => 'YL-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
            'full_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'wilaya' => fake()->city(),
            'commune' => fake()->city(),
            'address' => fake()->address(),
            'notes' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(['pending', 'confirmed', 'delivered', 'cancelled']),
            'items_total' => $itemsTotal,
            'delivery_price' => $deliveryPrice,
            'total' => $itemsTotal + $deliveryPrice,
        ];
    }
}
