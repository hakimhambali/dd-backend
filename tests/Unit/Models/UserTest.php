<?php

use App\Enums\RolesEnum;
use App\Enums\UserStatus;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;

beforeEach(function () {
    $this->seed(DatabaseSeeder::class);
});

test('can get user role attribute', function () {
    $user = User::factory()->create();
    $user->syncRoles(RolesEnum::ADMIN);

    expect($user->role)->toBe(RolesEnum::ADMIN->label());
});

describe('status attribute', function () {
    test('can get active status attribute', function () {
        $user = createUser();

        expect($user->status)->toBe(UserStatus::ACTIVE->label());
    });

    test('can get deactivate status attribute', function () {
        $user = createUser();
        $user->delete();

        expect($user->status)->toBe(UserStatus::DEACTIVATE->label());
    });

    test('can get pending status attribute', function () {
        $user = createUser();
        $user->email_verified_at = null;
        $user->save();

        $user->refresh();

        expect($user->status)->toBe(UserStatus::PENDING->label());
    });
});

test('user is an admin', function () {
    $user = User::factory()->create();
    $user->assignRole(RolesEnum::ADMIN);

    expect($user->isAdmin())->toBe(true);
});
