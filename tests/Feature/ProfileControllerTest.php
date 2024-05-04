<?php

use App\Enums\Gender;
use App\Enums\RolesEnum;
use App\Models\Profile;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

describe('update', function () {
    test('user can update profile', function () {
        $user = createUser(RolesEnum::EMPLOYEE);

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