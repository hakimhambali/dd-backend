<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameUser;

class GameUserSeeder extends Seeder
{
    public function run(): void
    {
        $gameuser1 = GameUser::updateOrCreate([
            'email' => 'gameuser1@gmail.com',
            'password' => bcrypt('passwordgameuser1'),
            'username' => 'Ice_John',
            'date_of_birth' => '1998-07-26',
            'country' => 'Malaysia',
            'platform' => 'Android',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '120.72',
            'highest_score' => '1124.89'
        ]);

        $gameuser2 = GameUser::updateOrCreate([
            'email' => 'gameuser2@gmail.com',
            'password' => bcrypt('passwordgameuser2'),
            'username' => 'Shah_Rukh',
            'date_of_birth' => '1998-07-27',
            'country' => 'Indonesia',
            'platform' => 'Ios',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '120.72',
            'highest_score' => '1024.89'
        ]);

        $gameuser3 = GameUser::updateOrCreate([
            'email' => 'gameuser3@gmail.com',
            'password' => bcrypt('passwordgameuser3'),
            'username' => 'Jack_Sparrow',
            'date_of_birth' => '1998-07-28',
            'country' => 'Hungary',
            'platform' => 'Android',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '52.72',
            'highest_score' => '1080.89'
        ]);

        $gameuser4 = GameUser::updateOrCreate([
            'email' => 'gameuser4@gmail.com',
            'password' => bcrypt('passwordgameuser4'),
            'username' => 'Olaf',
            'date_of_birth' => '1998-07-29',
            'country' => 'Sweeden',
            'platform' => 'Ios',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '22.72',
            'highest_score' => '3002.89'
        ]);

        $gameuser5 = GameUser::updateOrCreate([
            'email' => 'gameuser5@gmail.com',
            'password' => bcrypt('passwordgameuser5'),
            'username' => 'Will_Turner',
            'date_of_birth' => '1998-07-01',
            'country' => 'Denmark',
            'platform' => 'Ios',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '918.72',
            'highest_score' => '6002.89'
        ]);

        $gameuser6 = GameUser::updateOrCreate([
            'email' => 'gameuser6@gmail.com',
            'password' => bcrypt('passwordgameuser6'),
            'username' => 'Misteri',
            'date_of_birth' => '1998-07-02',
            'country' => 'Thailand',
            'platform' => 'Android',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '1918.72',
            'highest_score' => '9002.72'
        ]);

        $gameuser7 = GameUser::updateOrCreate([
            'email' => 'gameuser7@gmail.com',
            'password' => bcrypt('passwordgameuser7'),
            'username' => 'Lucrinex',
            'date_of_birth' => '1998-07-26',
            'country' => 'Finland',
            'platform' => 'Android',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '18.72',
            'highest_score' => '2.72'
        ]);

        $gameuser8 = GameUser::updateOrCreate([
            'email' => 'gameuser8@gmail.com',
            'password' => bcrypt('passwordgameuser8'),
            'username' => 'Jack_Frost',
            'date_of_birth' => '1998-07-26',
            'country' => 'Iran',
            'platform' => 'Ios',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '58.72',
            'highest_score' => '20.72'
        ]);

        $gameuser9 = GameUser::updateOrCreate([
            'email' => 'gameuser9@gmail.com',
            'password' => bcrypt('passwordgameuser9'),
            'username' => 'Yatoro',
            'date_of_birth' => '1998-07-26',
            'country' => 'Lubnan',
            'platform' => 'Ios',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '51.72',
            'highest_score' => '19.72'
        ]);

        $gameuser10 = GameUser::updateOrCreate([
            'email' => 'gameuser10@gmail.com',
            'password' => bcrypt('passwordgameuser10'),
            'username' => 'Miracle',
            'date_of_birth' => '1998-07-26',
            'country' => 'Syria',
            'platform' => 'Ios',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '38.72',
            'highest_score' => '1991.72'
        ]);

        $gameuser11 = GameUser::updateOrCreate([
            'email' => 'gameuser11@gmail.com',
            'password' => bcrypt('passwordgameuser11'),
            'username' => 'Arif_Aiman',
            'date_of_birth' => '1998-07-26',
            'country' => 'Palestin',
            'platform' => 'Android',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '3896.72',
            'highest_score' => '1810.72'
        ]);

        $gameuser11 = GameUser::updateOrCreate([
            'email' => 'gameuser12@gmail.com',
            'password' => bcrypt('passwordgameuser12'),
            'username' => 'Lionel_Messi',
            'date_of_birth' => '1998-07-26',
            'country' => 'Egypt',
            'platform' => 'Huawei',
            'register_date' => '2024-09-14 09:27:40',
            'total_play_time' => '1236.72',
            'highest_score' => '1230.72'
        ]);
    }
}
