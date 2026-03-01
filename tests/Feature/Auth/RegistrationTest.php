<?php

test('registration routes are not available when registration is disabled', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});