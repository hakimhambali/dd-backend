<?php

use App\Enums\RolesEnum;
use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

test('can get user role attribute', function () {
    $user = User::factory()->create();
    $user->syncRoles(RolesEnum::SUPERADMIN);

    expect($user->role)->toBe(RolesEnum::SUPERADMIN->label());
});

test('user is an superadmin', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::SUPERADMIN);

    expect($user->isSuperadmin())->toBe(true);
});

test('can filter list of users that is not superadmin', function () {
    $numOfUsers = 5;
    User::factory()->count($numOfUsers)->create();

    $superadmin = User::factory()->create();
    $superadmin->syncRoles(RolesEnum::SUPERADMIN);

    expect(User::notSuperadmin()->count())->toBe($numOfUsers);
});
