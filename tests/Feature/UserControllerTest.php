<?php

use App\Models\Profile;
use App\Models\User;
use App\Notifications\WelcomeUser;
use Database\Seeders\RoleSeeder;
use Illuminate\Support\Facades\Notification;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

describe('index', function () {
    test('can list all users', function () {
        $numOfUsers = 3;
        User::factory()->count($numOfUsers)->create();

        asSuperadmin()
            ->getJson('api/admin/users')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'email',
                        'role',
                        'profile' => [
                            'id',
                            'user_id',
                            'full_name',
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

    test('admin can search user by name', function () {
        $numOfUsers = 5;
        User::factory()->count($numOfUsers)->create();

        $user = User::first();

        $query = http_build_query([
            'name' => $user->profile->full_name,
        ]);

        asSuperadmin()
            ->getJson('api/admin/users?' . $query)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'id' => $user->id,
                'email' => $user->email,
            ]);
    });

    test('admin can search user by email', function () {
        $numOfUsers = 5;
        User::factory()->count($numOfUsers)->create();

        $user = User::first();

        $query = http_build_query([
            'email' => $user->email,
        ]);

        asSuperadmin()
            ->getJson('api/admin/users?' . $query)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'id' => $user->id,
                'email' => $user->email,
            ]);
    });
});

describe('store', function () {
    test('can store new user', function () {
        Notification::fake();

        $payload = [
            'email' => 'riepatil@ganmohi.hr',
            'name' => 'Leah Simon',
        ];

        asSuperadmin()
            ->postJson('api/admin/users', $payload)
            ->assertCreated();

        $user = User::firstWhere(['email' => $payload['email']]);

        $this->assertDatabaseHas(Profile::class, [
            'user_id' => $user->id,
        ]);

        Notification::assertCount(1);
        Notification::assertSentTo(
            [$user], WelcomeUser::class
        );
    });
});

describe('show', function () {
    test('admin can view a user', function () {
        $user = User::factory()->create();

        asSuperadmin()
            ->getJson('api/admin/users/' . $user->id)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'email',
                    'profile' => [
                        'full_name',
                    ],
                ],
            ])
            ->assertJsonFragment([
                'id' => $user->id,
                'email' => $user->email,
            ]);
    });

    test('admin cannot view invalid user', function () {
        asSuperadmin()
            ->getJson('api/admin/users/invalid-id')
            ->assertNotFound();
    });
});

describe('update', function () {
    test('can update user', function () {
        $user = createAdmin();

        asSuperadmin()
            ->putJson("api/admin/users/$user->id", [
                'email' => 'example@mail.test',
            ])
            ->assertOk();
    });
});

describe('destroy', function () {
    test('cannot delete auth user', function () {
        asSuperadmin()
            ->deleteJson('api/admin/users/1')
            ->assertForbidden();
    });

    test('can delete user', function () {
        $user = User::factory()->create();

        asSuperadmin()
            ->deleteJson('api/admin/users/' . $user->id)
            ->assertNoContent();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'email' => $user->email,
            'deleted_at' => now(),
        ]);
    });
});
