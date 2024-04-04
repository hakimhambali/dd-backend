<?php

use App\Models\User;

beforeEach(function () {
    $this->artisan('migrate');
});

describe('login', function () {
    test('user can login', function () {
        $user = User::factory()->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertOk();
    });
});
