<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;
use App\Models\GameUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch all game users once
        $gameUsers = GameUser::all();

        // Helper function to attach achievement to all game users if active
        $attachToAllGameUsers = function (Achievement $achievement) use ($gameUsers) {
            if ($achievement->is_active) {
                $now = Carbon::now();
                $data = [];

                foreach ($gameUsers as $gameUser) {
                    $data[] = [
                        'achievement_id' => $achievement->id,
                        'game_user_id' => $gameUser->id,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }

                // Insert in chunks to prevent memory issues
                $chunks = array_chunk($data, 500);
                foreach ($chunks as $chunk) {
                    DB::table('achievement_game_user')->insert($chunk);
                }
            }
        };

        // Achievement 1
        $achievement1 = Achievement::updateOrCreate(
            ['name' => 'Coins Lover'],
            [
                'description' => 'Collect 10000 coins to earn 500 gold',
                'max_score' => 10000.00,
                'is_active' => 1,
                'created_by' => 1,
                'product_rewarded_id' => 11,
            ]
        );
        $attachToAllGameUsers($achievement1);

        // Achievement 2
        $achievement2 = Achievement::updateOrCreate(
            ['name' => 'Skateboards Fiend'],
            [
                'description' => 'Use 100 skateboards to earn 1000 gold',
                'max_score' => 100.00,
                'reward_type' => 'Gold',
                'reward_value' => 1000,
                'is_active' => 1,
                'created_by' => 1,
            ]
        );
        $attachToAllGameUsers($achievement2);

        // Achievement 3
        $achievement3 = Achievement::updateOrCreate(
            ['name' => 'Marathon Life'],
            [
                'description' => 'Run for total 500 kilometers to earn 1000 gold',
                'max_score' => 500.00,
                'reward_type' => 'Gold',
                'reward_value' => 1000,
                'is_active' => 1,
                'created_by' => 1,
                'product_rewarded_id' => 3,
            ]
        );
        $attachToAllGameUsers($achievement3);
    }
}