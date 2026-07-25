<?php

use App\Models\Category;
use App\Models\Commune;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wilaya;

it('renders the storefront home page', function () {
    $this->get('/')->assertSuccessful()->assertSee('YALY.');
});

it('renders the product catalog', function () {
    Product::factory()->create();

    $this->get('/products')->assertSuccessful();
});

it('stores a customer order from a product page', function () {
    $product = Product::factory()->for(Category::factory())->create(['stock' => 5, 'price' => 2500]);
    $wilaya = Wilaya::factory()->create(['name' => 'Alger', 'delivery_price' => 600]);
    $commune = Commune::factory()->for($wilaya)->create(['name' => 'Hydra']);

    $response = $this->post(route('orders.store', $product), [
        'full_name' => 'Amine Haddad',
        'phone' => '0555000000',
        'wilaya_id' => $wilaya->id,
        'commune_id' => $commune->id,
        'address' => '12 Main Street',
        'quantity' => 2,
        'notes' => 'Call after 5 PM',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect();

    $order = Order::where('phone', '0555000000')->first();

    expect($order)->not->toBeNull()
        ->and($order->full_name)->toBe('Amine Haddad')
        ->and($order->wilaya)->toBe('Alger')
        ->and($order->commune)->toBe('Hydra')
        ->and((float) $order->items_total)->toBe(5000.0)
        ->and((float) $order->delivery_price)->toBe(600.0)
        ->and((float) $order->total)->toBe(5600.0)
        ->and($order->status)->toBe('pending');
});

it('rejects an order when the commune does not belong to the selected wilaya', function () {
    $product = Product::factory()->for(Category::factory())->create(['stock' => 5, 'price' => 2500]);
    $wilaya = Wilaya::factory()->create();
    $otherWilaya = Wilaya::factory()->create();
    $commune = Commune::factory()->for($otherWilaya)->create();

    $response = $this->post(route('orders.store', $product), [
        'full_name' => 'Amine Haddad',
        'phone' => '0555000000',
        'wilaya_id' => $wilaya->id,
        'commune_id' => $commune->id,
        'address' => '12 Main Street',
        'quantity' => 1,
    ]);

    $response->assertSessionHasErrors('commune_id')->assertRedirect();

    expect(Order::count())->toBe(0);
});
