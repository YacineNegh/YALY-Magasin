<?php

use App\Models\Admin;
use App\Models\Commune;
use App\Models\Wilaya;

it('returns delivery wilayas for the public order form', function () {
    $activeWilaya = Wilaya::factory()->create([
        'code' => 16,
        'name' => 'Alger',
        'delivery_price' => 600,
        'is_delivery_available' => true,
    ]);
    Commune::factory()->for($activeWilaya)->count(2)->create();

    Wilaya::factory()->create([
        'code' => 31,
        'is_delivery_available' => false,
    ]);

    $response = $this->getJson(route('locations.wilayas'));

    $response->assertSuccessful()
        ->assertJsonPath('data.0.name', 'Alger')
        ->assertJsonPath('data.0.delivery_price', 600)
        ->assertJsonPath('data.0.communes_count', 2);

    expect($response->json('data'))->toHaveCount(1);
});

it('returns communes for a selected wilaya', function () {
    $wilaya = Wilaya::factory()->create(['is_delivery_available' => true]);
    Commune::factory()->for($wilaya)->create(['name' => 'Hydra', 'daira_name' => 'Bir Mourad Rais']);

    $response = $this->getJson(route('locations.communes', $wilaya));

    $response->assertSuccessful()
        ->assertJsonPath('data.0.name', 'Hydra')
        ->assertJsonPath('data.0.daira_name', 'Bir Mourad Rais');
});

it('lets admins update wilaya delivery prices', function () {
    $admin = Admin::factory()->create();
    $wilaya = Wilaya::factory()->create([
        'delivery_price' => 700,
        'is_delivery_available' => true,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.delivery-prices.update'), [
        'wilayas' => [
            $wilaya->id => [
                'delivery_price' => 950,
                'is_delivery_available' => '0',
            ],
        ],
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect();

    expect((float) $wilaya->refresh()->delivery_price)->toBe(950.0)
        ->and($wilaya->is_delivery_available)->toBeFalse();
});
