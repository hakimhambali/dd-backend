<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

describe('index', function () {
    test('can list all users', function () {
        User::factory()->count(5)->create();

        $this->actingAs(User::factory()->create())
            ->getJson('api/users')
            ->assertOk()
            ->assertJsonCount(6, 'data');
    });
});
