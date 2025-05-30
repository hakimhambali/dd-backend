<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameUser;
use App\Enums\RolesEnum;

class GameUserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'email' => 'gameuser1@gmail.com',
                'password' => bcrypt('passwordgameuser1'),
                'username' => 'Ice_John',
                'date_of_birth' => '1998-07-26',
                'country' => 'Malaysia',
                'platform' => 'Android',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '120.72',
                'highest_score' => '1124.89',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser2@gmail.com',
                'password' => bcrypt('passwordgameuser2'),
                'username' => 'Shah_Rukh',
                'date_of_birth' => '1998-07-27',
                'country' => 'Indonesia',
                'platform' => 'Ios',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '120.72',
                'highest_score' => '1024.89',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser3@gmail.com',
                'password' => bcrypt('passwordgameuser3'),
                'username' => 'Jack_Sparrow',
                'date_of_birth' => '1998-07-28',
                'country' => 'Hungary',
                'platform' => 'Android',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '52.72',
                'highest_score' => '1080.89',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser4@gmail.com',
                'password' => bcrypt('passwordgameuser4'),
                'username' => 'Olaf',
                'date_of_birth' => '1998-07-29',
                'country' => 'Sweeden',
                'platform' => 'Ios',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '22.72',
                'highest_score' => '3002.89',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser5@gmail.com',
                'password' => bcrypt('passwordgameuser5'),
                'username' => 'Will_Turner',
                'date_of_birth' => '1998-07-01',
                'country' => 'Denmark',
                'platform' => 'Ios',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '918.72',
                'highest_score' => '6002.89',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser6@gmail.com',
                'password' => bcrypt('passwordgameuser6'),
                'username' => 'Misteri',
                'date_of_birth' => '1998-07-02',
                'country' => 'Thailand',
                'platform' => 'Android',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '1918.72',
                'highest_score' => '9002.72',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser7@gmail.com',
                'password' => bcrypt('passwordgameuser7'),
                'username' => 'Lucrinex',
                'date_of_birth' => '1998-07-26',
                'country' => 'Finland',
                'platform' => 'Android',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '18.72',
                'highest_score' => '2.72',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser8@gmail.com',
                'password' => bcrypt('passwordgameuser8'),
                'username' => 'Jack_Frost',
                'date_of_birth' => '1998-07-26',
                'country' => 'Iran',
                'platform' => 'Ios',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '58.72',
                'highest_score' => '20.72',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser9@gmail.com',
                'password' => bcrypt('passwordgameuser9'),
                'username' => 'Yatoro',
                'date_of_birth' => '1998-07-26',
                'country' => 'Lubnan',
                'platform' => 'Ios',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '51.72',
                'highest_score' => '19.72',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser10@gmail.com',
                'password' => bcrypt('passwordgameuser10'),
                'username' => 'Miracle',
                'date_of_birth' => '1998-07-26',
                'country' => 'Syria',
                'platform' => 'Ios',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '38.72',
                'highest_score' => '1991.72',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser11@gmail.com',
                'password' => bcrypt('passwordgameuser11'),
                'username' => 'Arif_Aiman',
                'date_of_birth' => '1998-07-26',
                'country' => 'Palestin',
                'platform' => 'Android',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '3896.72',
                'highest_score' => '1810.72',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'email' => 'gameuser12@gmail.com',
                'password' => bcrypt('passwordgameuser12'),
                'username' => 'Lionel_Messi',
                'date_of_birth' => '1998-07-26',
                'country' => 'Egypt',
                'platform' => 'Huawei',
                'register_date' => '2024-09-14 09:27:40',
                'total_play_time' => '1236.72',
                'highest_score' => '1230.72',
                'last_login' => '2024-09-14 09:27:40',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        GameUser::insert($users);

        $emails = collect($users)->pluck('email');
        $gameUsers = GameUser::whereIn('email', $emails)->get();

        // Assign role in bulk
        foreach ($gameUsers as $user) {
            $user->assignRole(RolesEnum::PLAYER);
        }
    }
}
