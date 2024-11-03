<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Item;

class ItemProductSeeder extends Seeder
{
    public function run(): void
    {
        $item1 = Item::updateOrCreate([
            'item_type' => 'Skateboard',
            'created_by' => 1,
        ]);

        $item2 = Item::updateOrCreate([
            'item_type' => 'StartBooster',
            'created_by' => 1,
        ]);

        $item3 = Item::updateOrCreate([
            'item_type' => 'Start2XExp',
            'created_by' => 1,
        ]);

        $product1 = Product::updateOrCreate([
            'code' => 'IC_1',
        ], [
            'name' => 'Bundle Mania',
            'price_real' => 39.99,
            'price_game' => 2999,
            'price_game_type' => 'Gold',
            'product_type' => 'Item Consumable',
            'description' => 'Purchase this only for 2999 of Gold!',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $product1->items()->sync([
            $item1->id => ['count' => 10],
            $item2->id => ['count' => 20],
            $item3->id => ['count' => 30],
        ]);
    }
}