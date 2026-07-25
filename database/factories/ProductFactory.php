<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'category_id' => Category::factory(),
            'name' => Str::headline($name),
            'slug' => Str::slug($name),
            'price' => fake()->randomFloat(2, 1200, 80000),
            'stock' => fake()->numberBetween(0, 60),
            'description' => fake()->paragraphs(2, true),
            'specifications' => fake()->sentences(4, true),
            'status' => 'active',
            'is_featured' => fake()->boolean(35),
        ];
    }
}
