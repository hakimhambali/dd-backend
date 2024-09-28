<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameUser;

class GameUserSeeder extends Seeder
{
    public function run(): void
    {
        $gameuser = GameUser::updateOrCreate([
            'email' => 'gameuser@gmail.com',
            'password' => bcrypt('passwordgameuser'),
            'username' => 'Ice_John',
            'date_of_birth' => '1998-07-26',
            'country' => 'Malaysia',
            'platform' => 'Ios',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '0',
        ]);
    }
}
