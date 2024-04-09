<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate([
            'email' => 'admin@mail.test',
        ], [
            'name' => 'Admin',
            'password' => bcrypt('password'),
            'status' => UserStatus::ACTIVE->name,
        ]);

        $admin->assignRole(RolesEnum::ADMIN);
    }
}
