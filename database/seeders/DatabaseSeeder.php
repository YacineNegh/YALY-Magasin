<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AlgeriaLocationSeeder::class);

        Admin::firstOrCreate(
            ['email' => 'admin@ylstore.test'],
            ['name' => 'YALY. Admin', 'password' => 'password'],
        );

        $categories = collect([
            ['name' => 'Smart Devices', 'description' => 'Practical technology for home, work, and daily routines.'],
            ['name' => 'Home Essentials', 'description' => 'Clean, useful products for a more comfortable home.'],
            ['name' => 'Lifestyle', 'description' => 'Everyday accessories selected for quality and ease of use.'],
        ])->mapWithKeys(function (array $category): array {
            $model = Category::firstOrCreate(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'description' => $category['description'], 'status' => 'active'],
            );

            return [$category['name'] => $model];
        });

        $products = [
            [
                'category' => 'Smart Devices',
                'name' => 'Aurora Wireless Speaker',
                'price' => 8900,
                'stock' => 18,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1545454675-3531b543be5d?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A compact wireless speaker with clear sound, stable Bluetooth pairing, and a minimal profile for desks, kitchens, and bedside tables.',
                'specifications' => "Bluetooth 5.3\nUp to 12 hours battery\nUSB-C charging\nMatte soft-touch finish",
            ],
            [
                'category' => 'Home Essentials',
                'name' => 'Luma Desk Lamp',
                'price' => 6400,
                'stock' => 24,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A slim LED desk lamp with warm and cool light modes, built for focused work and evening reading.',
                'specifications' => "Three brightness levels\nAdjustable arm\nLow heat LED panel\nTouch controls",
            ],
            [
                'category' => 'Lifestyle',
                'name' => 'Metro Everyday Backpack',
                'price' => 11800,
                'stock' => 11,
                'featured' => true,
                'image' => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A structured everyday backpack with laptop storage, organizer pockets, and a clean city-ready finish.',
                'specifications' => "15-inch laptop sleeve\nWater-resistant shell\nHidden back pocket\nPadded shoulder straps",
            ],
            [
                'category' => 'Smart Devices',
                'name' => 'Pulse Fitness Band',
                'price' => 7200,
                'stock' => 30,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A lightweight fitness band for steps, heart-rate tracking, reminders, and daily activity snapshots.',
                'specifications' => "Color display\nActivity tracking\nSleep insights\nSplash resistant",
            ],
            [
                'category' => 'Home Essentials',
                'name' => 'Nora Storage Set',
                'price' => 3900,
                'stock' => 36,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A modular storage set for shelves, wardrobes, and workspaces that need a calmer, tidier layout.',
                'specifications' => "Set of 4 pieces\nStackable design\nEasy-clean surface\nNeutral finish",
            ],
            [
                'category' => 'Lifestyle',
                'name' => 'Cairo Travel Tumbler',
                'price' => 2800,
                'stock' => 42,
                'featured' => false,
                'image' => 'https://images.unsplash.com/photo-1524678606370-a47ad25cb82a?auto=format&fit=crop&w=1200&q=80',
                'description' => 'A double-wall travel tumbler for commutes, offices, and long errands.',
                'specifications' => "500 ml capacity\nDouble-wall insulation\nLeak-resistant lid\nFits cup holders",
            ],
        ];

        foreach ($products as $product) {
            $model = Product::firstOrCreate(
                ['slug' => Str::slug($product['name'])],
                [
                    'category_id' => $categories[$product['category']]->id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'description' => $product['description'],
                    'specifications' => $product['specifications'],
                    'status' => 'active',
                    'is_featured' => $product['featured'],
                ],
            );

            $model->images()->firstOrCreate(
                ['image_path' => $product['image']],
                ['alt_text' => $product['name'], 'is_primary' => true, 'sort_order' => 0],
            );
        }
    }
}
