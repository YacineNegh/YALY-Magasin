<?php

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

test('admin password can be updated from settings', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin)->put('/admin/settings', [
        'name' => $admin->name,
        'email' => $admin->email,
        'password' => 'new-password',
        'password_confirmation' => 'new-password',
    ]);

    $response->assertSessionHasNoErrors()->assertRedirect('/admin/settings');
    expect(Hash::check('new-password', $admin->refresh()->password))->toBeTrue();
});
