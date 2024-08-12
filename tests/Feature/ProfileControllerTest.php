<?php

use App\Models\Gender;
use App\Models\Profile;
use Database\Seeders\GenderSeeder;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed([
        RoleSeeder::class,
        GenderSeeder::class,
    ]);
});

describe('show', function () {
    test('user can view their own profile', function () {
        $user = createUser();

        $user->profile->update(['gender_id' => Gender::ID_MALE]);

        $this->actingAs($user)
            ->getJson('api/profile')
            ->assertOk()
            ->assertJsonFragment([
                'id' => $user->id,
            ])
            ->assertJsonFragment([
                'id' => $user->profile->id,
                'full_name' => $user->profile->full_name,
                'gender_id' => Gender::ID_MALE,
            ])
            ->assertJsonFragment([
                'id' => Gender::ID_MALE,
                'name' => Gender::NAMES[Gender::ID_MALE],
            ]);
    });
});

describe('update', function () {
    test('user can update profile', function () {
        $user = createUser();

        $payload = [
            'full_name' => 'Another Name',
            'gender_id' => Gender::ID_MALE,
            'nric_passport' => '990910011001',
            'phone_number' => '(317) 435-9926',
        ];

        $this->actingAs($user)
            ->putJson('api/profile', $payload)
            ->assertNoContent();

        $payload['user_id'] = $user->id;

        $this->assertDatabaseHas(Profile::class, $payload);
    });

    test('user cannot update profile if gender is invalid', function () {
        $user = createUser();

        $payload = [
            'gender_id' => 'Invalid',
        ];

        $this->actingAs($user)
            ->putJson('api/profile', $payload)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['gender_id']);

        $this->assertDatabaseMissing(Profile::class, $payload);
    });
});
