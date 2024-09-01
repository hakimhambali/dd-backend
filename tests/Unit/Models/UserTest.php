<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('can get user role attribute', function () {
    $user = User::factory()->create();
    $user->syncRoles(RolesEnum::ADMIN);

    expect($user->role)->toBe(RolesEnum::ADMIN->label());
});

test('user is an admin', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::ADMIN);

    expect($user->isAdmin())->toBe(true);
});

test('can filter list of users that is not admin', function () {
    $numOfUsers = 5;
    User::factory()->count($numOfUsers)->create();

    $admin = User::factory()->create();
    $admin->syncRoles(RolesEnum::ADMIN);

    expect(User::notAdmin()->count())->toBe($numOfUsers);
});
