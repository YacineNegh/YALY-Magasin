<?php

test('password reset screens are not publicly exposed', function () {
    $this->get('/forgot-password')->assertNotFound();
    $this->get('/reset-password/token')->assertNotFound();
});
