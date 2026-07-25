<?php

test('email verification is not required for administrators', function () {
    $this->get('/verify-email')->assertNotFound();
});
