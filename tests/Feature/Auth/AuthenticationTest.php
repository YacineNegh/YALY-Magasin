<?php

use App\Models\Admin;

test('admin login screen can be rendered', function () {
    $this->get('/admin/login')->assertSuccessful();
});

test('admins can authenticate using the login screen', function () {
    $admin = Admin::factory()->create();

    $response = $this->post('/admin/login', [
        'email' => $admin->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticatedAs($admin);
    $response->assertRedirect(route('admin.dashboard', absolute: false));
});

test('admins can not authenticate with invalid password', function () {
    $admin = Admin::factory()->create();

    $this->post('/admin/login', [
        'email' => $admin->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('admins can logout', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin)->post('/admin/logout');

    $this->assertGuest();
    $response->assertRedirect(route('home'));
});
