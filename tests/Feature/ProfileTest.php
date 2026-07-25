<?php

use App\Models\Admin;

test('admin profile settings can be updated', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin)->put('/admin/settings', [
        'name' => 'Store Owner',
        'email' => 'owner@ylstore.test',
        'password' => null,
        'password_confirmation' => null,
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect('/admin/settings');

    $admin->refresh();

    expect($admin->name)->toBe('Store Owner')
        ->and($admin->email)->toBe('owner@ylstore.test');
});
