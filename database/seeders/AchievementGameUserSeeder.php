<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameUser;
use App\Models\Achievement;
use Illuminate\Support\Facades\DB;

class AchievementGameUserSeeder extends Seeder
{
    public function run(): void
    {
        $gameUsers = GameUser::all();
        $achievements = Achievement::all();

        foreach ($gameUsers as $gameUser) {
            foreach ($achievements as $achievement) {
                DB::table('achievement_game_user')->updateOrInsert(
                    [
                        'game_user_id' => $gameUser->id,
                        'achievement_id' => $achievement->id,
                    ],
                    [
                        'score' => 0,
                        'is_completed' => 0,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}