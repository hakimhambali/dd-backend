<?php

use App\Enums\Gender;
use App\Models\Profile;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

describe('show', function () {
    test('user can view their own profile', function () {
        $user = createUser();

        $this->actingAs($user)
            ->getJson('api/profile')
            ->assertOk()
            ->assertJsonFragment([
                'id' => $user->id,
            ])
            ->assertJsonFragment([
                'id' => $user->profile->id,
                'full_name' => $user->profile->full_name,
            ]);
    });
});

describe('update', function () {
    test('user can update profile', function () {
        $user = createUser();

        $payload = [
            'full_name' => 'Another Name',
            'gender' => Gender::MALE->value,
            'nric_passport' => '990910011001',
            'phone_number' => '(317) 435-9926',
        ];

        $this->actingAs($user)->putJson('api/profile', $payload)
            ->assertNoContent();

        $payload['user_id'] = $user->id;

        $this->assertDatabaseHas(Profile::class, $payload);
    });
});