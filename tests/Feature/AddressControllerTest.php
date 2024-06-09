<?php

use App\Models\Address;
use App\Models\User;
use Database\Seeders\RoleSeeder;

beforeEach(function () {
    $this->seed(RoleSeeder::class);
});

describe('index', function () {
    test('user can get their addresses', function () {
        $user = createUser();
        $numOfAddresses = 3;

        Address::factory()->for($user, 'addressable')->count($numOfAddresses)->create();

        $this->actingAs($user)
            ->getJson('api/addresses')
            ->assertOk()
            ->assertJsonCount($numOfAddresses, 'data');
    });

    test('user can filter their addresses by unit no', function () {
        $user = createUser();
        $numOfAddresses = 3;

        Address::factory()->for($user, 'addressable')->count($numOfAddresses)->create();

        $address = Address::where('addressable_id', $user->id)->first();

        $query = http_build_query([
            'unit_no' => $address->unit_no,
        ]);

        // dd(Address::all());

        $this->actingAs($user)
            ->getJson('api/addresses?' . $query)
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonFragment([
                'id' => $address->id,
                'unit_no' => $address->unit_no,
            ]);
    });

    test('user cannot get other user\'s addresses', function () {
        $user = createUser();
        $numOfAddresses = 3;

        Address::factory()->for($user, 'addressable')->count($numOfAddresses)->create();

        $this->actingAs(createUser())
            ->getJson('api/addresses')
            ->assertOk()
            ->assertJsonCount(0, 'data')
            ->assertJsonMissing([
                'addressable_id' => $user->id,
            ]);
    });
});

describe('store', function () {
    test('user can store new address', function () {
        $user = createUser();

        $this->assertDatabaseMissing(Address::class, [
            'addressable_id' => $user->id,
        ]);

        $payload = [
            'unit_no' => '21',
            'address_1' => 'Tavop Court',
            'address_2' => 'Ruwuv Loop',
            'postcode' => '29001',
            'city' => 'Irifutan',
            'state' => 'Fouhojef',
            'country' => 'French Guiana',
        ];

        $this->actingAs($user)
            ->postJson('api/addresses', $payload)
            ->assertCreated();

        $data = array_merge($payload, [
            'addressable_type' => User::class,
            'addressable_id' => $user->id,
        ]);

        $this->assertDatabaseHas(Address::class, $data);
    });
});

describe('show', function () {
    test('user can get one of their addresses', function () {
        $user = createUser();
        $numOfAddresses = 3;

        Address::factory()->for($user, 'addressable')->count($numOfAddresses)->create();

        $address = Address::where('addressable_id', $user->id)->first();

        $this->actingAs($user)
            ->getJson("api/addresses/$address->id")
            ->assertOk()
            ->assertJsonFragment([
                'id' => $address->id,
                'addressable_id' => $user->id,
                'unit_no' => $address->unit_no,
                'address_1' => $address->address_1,
            ]);
    });
});
