<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mission;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        $mission1 = Mission::updateOrCreate(
            ['name' => 'Coins Mania'],
            [
                'description' => 'Collect 1000 coins today to earn 90 gold',
                'max_score' => 1000.00,
                'is_active' => 1,
                'created_by' => 1,
                'product_rewarded_id' => 1,
            ]
        );

        $mission2 = Mission::updateOrCreate(
            ['name' => 'Skateboards Enthusiast'],
            [
                'description' => 'Use 10 skateboards today to earn 100 gold',
                'max_score' => 10.00,
                'reward_type' => 'Gold',
                'reward_value' => 100,
                'is_active' => 1,
                'created_by' => 1,
            ]
        );

        $mission3 = Mission::updateOrCreate(
            ['name' => 'Marathon'],
            [
                'description' => 'Run for total 5 kilometers today to earn 50 gold',
                'max_score' => 5.00,
                'reward_type' => 'Gem',
                'reward_value' => 50,
                'is_active' => 1,
                'created_by' => 1,
                'product_rewarded_id' => 3,
            ]
        );
    }
}
