<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mission;
use App\Models\Product;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        // Preload necessary products
        $products = Product::with(['skin'])
            ->where(function ($query) {
                $query->where('product_type', 'Skin')
                    ->whereHas('skin', function ($q) {
                        $q->whereIn('skin_tier', ['common', 'uncommon']);
                    })
                    ->orWhereHas('items');
            })->get();

        if ($products->isEmpty()) {
            $this->command->warn("No eligible products found for seeding missions.");
            return;
        }

        $names = ['Coins Mania', 'Skateboards Enthusiast', 'Marathon', 'Treasure Hunter', 'Speed Racer'];
        $descriptions = [
            'Collect coins to earn gold',
            'Use skateboards to earn rewards',
            'Run a certain distance to earn gold',
            'Reach a high score to earn rewards',
            'Complete a level to earn points'
        ];

        $missionsToCreate = [];

        for ($i = 1; $i <= 200; $i++) {
            $index = ($i - 1) % count($names);
            $baseName = $names[$index];
            $description = $descriptions[$index];
            $maxScore = rand(1, 50) * 20;
            $rewardType = 'Gold';
            $rewardValue = $maxScore;

            // Optionally generate unique name without querying DB each time
            $missionNumber = ceil($i / count($names)); // Generate 1, 1, 1... then 2, 2, 2...
            $name = $baseName . ' ' . $missionNumber;

            $missionsToCreate[] = [
                'name' => $name,
                'description' => $description,
                'max_score' => $maxScore,
                'reward_type' => $rewardType,
                'reward_value' => $rewardValue,
                'is_active' => 1,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        // Batch insert all missions
        Mission::insert($missionsToCreate);
    }
}