<?php

use App\Models\Profile;
use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

describe('index', function () {
    test('can list all users', function () {
        $numOfUsers = 5;
        User::factory()->count($numOfUsers)->create();

        asAdmin()
            ->getJson('api/admin/users')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'email',
                        'role',
                        'status',
                        'profile' => [
                            'id',
                            'user_id',
                            'full_name',
                            'gender',
                        ],
                        'created_at',
                        'updated_at',
                    ]
                ]
            ])
            ->assertJsonCount($numOfUsers, 'data');
    });

    test('user cannot get list if not an admin', function () {
        $numOfUsers = 5;
        User::factory()->count($numOfUsers)->create();

        $this->actingAs(User::first())
            ->getJson('api/admin/users')
            ->assertForbidden();
    });
});

describe('store', function () {
    test('can store new user', function () {
        $payload = [
            'email' => 'riepatil@ganmohi.hr',
        ];

        asAdmin()
            ->postJson('api/admin/users', $payload)
            ->assertCreated();

        $user = User::firstWhere(['email' => $payload['email']]);

        $this->assertDatabaseHas(Profile::class, [
            'user_id' => $user->id,
        ]);
    });
});
