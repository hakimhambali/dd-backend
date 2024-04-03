<?php

use App\Models\User;

beforeEach(function () {
    $this->artisan('migrate');
});

describe('login', function () {
    test('user can login', function () {
        $user = User::create([
            'name' => 'Brandon Lewis',
            'email' => 'kifke@nuwno.fi',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertOk()
            ->assertJsonStructure([
                'token'
            ]);
    });
});
