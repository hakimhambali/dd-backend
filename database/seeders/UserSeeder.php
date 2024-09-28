<?php

namespace Database\Seeders;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = User::updateOrCreate([
            'email' => 'superadmin@gmail.com',
        ], [
            'password' => bcrypt('passwordsuperadmin'),
        ]);

        $superadmin->markEmailAsVerified();

        $superadmin->assignRole(RolesEnum::SUPERADMIN);

        $superadmin->profile()->updateOrCreate([
            'user_id' => $superadmin->id,
        ], [
            'full_name' => 'Superadmin',
            'staff_no' => 'A17CS0115',
            'nric_passport' => '900601058759',
            'phone_number' => '0118742151',
        ]);
    }
}
