<?php

use App\Models\Admin;

test('admin settings screen can be rendered', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin)->get('/admin/settings')->assertSuccessful();
});
