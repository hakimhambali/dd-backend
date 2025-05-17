<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mission;
use App\Models\Product;
use App\Models\Skin;

class MissionSeeder extends Seeder
{
    public function run(): void
    {
        // Fetch Products with associated Skin and common tier
        $products = Product::with(['skin', 'items'])
        ->where(function ($query) {
            $query->where('product_type', 'Skin')
                ->whereHas('skin', function ($query) {
                    $query->whereIn('skin_tier', ['common', 'uncommon']);
                })
                ->orWhereHas('items'); // Include products with associated items
        })->get();

        $names = ['Coins Mania', 'Skateboards Enthusiast', 'Marathon', 'Treasure Hunter', 'Speed Racer'];
        $descriptions = [
            'Collect coins to earn gold',
            'Use skateboards to earn rewards',
            'Run a certain distance to earn gold',
            'Reach a high score to earn rewards',
            'Complete a level to earn points'
        ];
        // $rewardTypes = ['Gold', 'Gem'];

        // Define skin tiers and their equivalent gold values
        // $skinGoldValues = [
        //     'common' => 100,
        //     'uncommon' => 1000,
        //     'rare' => 10000,
        //     'legendary' => 100000,
        // ];

        for ($i = 1; $i <= 200; $i++) {
            $index = ($i - 1) % count($names); // Cycle through names
            $baseName = $names[$index];
            $description = $descriptions[$index];
            $maxScore = rand(1, 50) * 20;

            // Calculate reward value based on max_score and tier values
            $rewardValue = $maxScore; // Start with max_score equivalent in gold

            // Optionally include a product reward if available
            $selectedProduct = $products->random();
            $skin = $selectedProduct->skin;

            // if ($skin && isset($skinGoldValues[$skin->skin_tier])) {
            //     $rewardValue += $skinGoldValues[$skin->skin_tier];
            // }

            $rewardType = 'Gold';
            // Determine reward type
            // if (strpos($description, 'gold') !== false) {
            //     $rewardType = 'Gold';
            // } elseif (strpos($description, 'gems') !== false) {
            //     $rewardType = 'Gem';
            //     $rewardValue = max(1, round($rewardValue / 100)); // Convert gold to gems, rounding to the nearest whole number
            // } else {
            //     $rewardType = 'Gold';
            // }

            // Assign product_rewarded_id to 20% of missions
            $productRewardedId = (rand(1, 100) <= 20) ? $selectedProduct->id : null;

            $existingCount = Mission::where('name', 'like', "$baseName%")->count();
            $name = $baseName . ' ' . ($existingCount + 1);

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
