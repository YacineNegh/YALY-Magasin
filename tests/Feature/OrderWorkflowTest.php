<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;

test('admin confirmation reserves product stock', function () {
    $admin = Admin::factory()->create();
    $product = Product::factory()->for(Category::factory())->create(['stock' => 5, 'price' => 2000]);
    $order = Order::factory()->create(['status' => 'pending', 'total' => 4000]);
    $order->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'unit_price' => $product->price,
        'quantity' => 2,
        'subtotal' => 4000,
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.orders.confirm', $order));

    $response->assertSessionHasNoErrors()->assertRedirect();
    expect($order->refresh()->status)->toBe('confirmed')
        ->and($product->refresh()->stock)->toBe(3);
});

test('admin cancellation restores reserved stock', function () {
    $admin = Admin::factory()->create();
    $product = Product::factory()->for(Category::factory())->create(['stock' => 3, 'price' => 2000]);
    $order = Order::factory()->create(['status' => 'confirmed', 'total' => 4000]);
    $order->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'unit_price' => $product->price,
        'quantity' => 2,
        'subtotal' => 4000,
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.orders.cancel', $order));

    $response->assertSessionHasNoErrors()->assertRedirect();
    expect($order->refresh()->status)->toBe('cancelled')
        ->and($product->refresh()->stock)->toBe(5);
});

test('admin delivery from pending reserves product stock once', function () {
    $admin = Admin::factory()->create();
    $product = Product::factory()->for(Category::factory())->create(['stock' => 5, 'price' => 2000]);
    $order = Order::factory()->create(['status' => 'pending', 'total' => 4000]);
    $order->items()->create([
        'product_id' => $product->id,
        'product_name' => $product->name,
        'unit_price' => $product->price,
        'quantity' => 2,
        'subtotal' => 4000,
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.orders.deliver', $order));

    $response->assertSessionHasNoErrors()->assertRedirect();
    expect($order->refresh()->status)->toBe('delivered')
        ->and($product->refresh()->stock)->toBe(3);
});
