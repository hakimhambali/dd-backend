<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Achievement;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievement1 = Achievement::updateOrCreate(
            ['name' => 'Coins Lover'],
            [
                'description' => 'Collect 10000 coins to earn 500 gold',
                'max_score' => 10000.00,
                'is_active' => 1,
                'created_by' => 1,
                'product_rewarded_id' => 1,
            ]
        );

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
    }
}
