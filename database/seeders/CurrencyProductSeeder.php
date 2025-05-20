<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Currency;

class CurrencyProductSeeder extends Seeder
{
    public function run(): void
    {
        // Define all products with improved descriptions (no hyphens)
        $products = [
            // GOLD
            [
                'code' => 'CU_1',
                'name' => 'Crumb',
                'price_real' => 0.99,
                'currency_type' => 'Gold',
                'currency_value' => 1000,
                'description' => 'A tiny sprinkle of gold to start your journey',
            ],
            [
                'code' => 'CU_2',
                'name' => 'Sprinkle',
                'price_real' => 8.99,
                'currency_type' => 'Gold',
                'currency_value' => 10000,
                'description' => 'More than crumbs give yourself a solid boost',
            ],
            [
                'code' => 'CU_3',
                'name' => 'Glitter',
                'price_real' => 87.99,
                'currency_type' => 'Gold',
                'currency_value' => 100000,
                'description' => 'Starts to shine and gives you a mid tier haul',
            ],
            [
                'code' => 'CU_4',
                'name' => 'Shine',
                'price_real' => 859.99,
                'currency_type' => 'Gold',
                'currency_value' => 1000000,
                'description' => 'Glowing reward that keeps you going strong',
            ],
            [
                'code' => 'CU_5',
                'name' => 'Treasure',
                'price_real' => 8399.99,
                'currency_type' => 'Gold',
                'currency_value' => 10000000,
                'description' => 'Massive amount of gold that feels like a big win',
            ],
            [
                'code' => 'CU_6',
                'name' => 'Gold Rush',
                'price_real' => 81999.99,
                'currency_type' => 'Gold',
                'currency_value' => 100000000,
                'description' => 'The ultimate pack filled with pure gold mania',
            ],

            // GEMS
            [
                'code' => 'CU_7',
                'name' => 'Salt',
                'price_real' => 0.99,
                'currency_type' => 'Gem',
                'currency_value' => 10,
                'description' => 'Your first pinch of premium spice to unlock more',
            ],
            [
                'code' => 'CU_8',
                'name' => 'Basil',
                'price_real' => 8.99,
                'currency_type' => 'Gem',
                'currency_value' => 100,
                'description' => 'Fresh flavor that unlocks more gems for you',
            ],
            [
                'code' => 'CU_9',
                'name' => 'Chili',
                'price_real' => 87.99,
                'currency_type' => 'Gem',
                'currency_value' => 1000,
                'description' => 'Spice things up and gain access to more power',
            ],
            [
                'code' => 'CU_10',
                'name' => 'Cinnamon',
                'price_real' => 859.99,
                'currency_type' => 'Gem',
                'currency_value' => 10000,
                'description' => 'Sweet and strong gem pack to unlock cool skins',
            ],
            [
                'code' => 'CU_11',
                'name' => 'Saffron',
                'price_real' => 8399.99,
                'currency_type' => 'Gem',
                'currency_value' => 100000,
                'description' => 'Rare and valuable gem pack for elite skins',
            ],
            [
                'code' => 'CU_12',
                'name' => 'Diamond Spice',
                'price_real' => 81999.99,
                'currency_type' => 'Gem',
                'currency_value' => 1000000,
                'description' => 'Ultimate gem pack filled with pure luxury',
            ],
        ];

        foreach ($products as $data) {
            $product = Product::updateOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'price_real' => $data['price_real'],
                    'product_type' => 'Currency',
                    'description' => $data['description'],
                    'is_active' => 1,
                    'created_by' => 1,
                ]
            );

            Currency::updateOrCreate(
                ['product_id' => $product->id],
                [
                    'currency_type' => $data['currency_type'],
                    'currency_value' => $data['currency_value']
                ]
            );
        }
    }
}