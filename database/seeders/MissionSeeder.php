<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mission;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Coins Mania', 'Skateboards Enthusiast', 'Marathon', 'Treasure Hunter', 'Speed Racer'];
        $descriptions = [
            'Collect coins to earn gold',
            'Use skateboards to earn rewards',
            'Run a certain distance to earn gems',
            'Reach a high score to earn items',
            'Complete a level to earn points'
        ];
        $rewardTypes = ['Gold', 'Gem'];
        $productIds = [1, 2, 3];
        
        for ($i = 1; $i <= 100; $i++) {
            $name = $names[array_rand($names)] . " " . $i;
            $description = $descriptions[array_rand($descriptions)];
            $maxScore = rand(10, 1000);
            $rewardType = $rewardTypes[array_rand($rewardTypes)];
            $rewardValue = rand(10, 200);
            
            $productRewardedId = $i % 5 === 0 ? $productIds[array_rand($productIds)] : null;

            Mission::updateOrCreate(
                ['name' => $name],
                [
                    'description' => $description,
                    'max_score' => $maxScore,
                    'reward_type' => $rewardType,
                    'reward_value' => $rewardValue,
                    'is_active' => 1,
                    'created_by' => 1,
                    'product_rewarded_id' => $productRewardedId,
                ]
            );
        }
    }
}
