<?php

test('public registration is not available', function () {
    $this->get('/register')->assertNotFound();
});

test('public customers are redirected away from admin pages', function () {
    $this->get('/admin/dashboard')->assertRedirect(route('login'));
});
