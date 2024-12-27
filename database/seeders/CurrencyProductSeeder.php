<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Currency;

class CurrencyProductSeeder extends Seeder
{
    public function run(): void
    {
        $product1 = Product::updateOrCreate([
            'code' => 'CU_1',
        ], [
            'name' => 'Gold Bar',
            'price_real' => 19.99,
            'price_game' => 1999,
            'price_game_type' => 'Gold',
            'product_type' => 'Currency',
            'description' => 'New gold collection',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $currency1 = Currency::updateOrCreate([
            'product_id' => $product1->id,
        ], [
            'currency_type' => 'Gold',
            'currency_value' => 1999,
        ]);

        $product2 = Product::updateOrCreate([
            'code' => 'CU_2',
        ], [
            'name' => 'Bucket Gem',
            'price_real' => 29.99,
            'product_type' => 'Currency',
            'description' => 'Shopping time',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $currency2 = Currency::updateOrCreate([
            'product_id' => $product2->id,
        ], [
            'currency_type' => 'Gem',
            'currency_value' => 99,
        ]);
    }
}