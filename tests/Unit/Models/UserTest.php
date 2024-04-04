<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('user is an admin', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::ADMIN);

    expect($user->isAdmin())->toBe(true);
});
