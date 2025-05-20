<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Skin;
use App\Models\Item;

class SkinProductSeeder extends Seeder
{
    public function run(): void
    {
        $product1 = Product::updateOrCreate([
            'code' => 'SO_14',
        ], [
            'name' => 'Summer Skin',
            'price_real' => 19.99,
            'price_game' => 1999,
            'price_game_type' => 'Gold',
            'product_type' => 'Skin',
            'description' => 'Fresh look summer skin',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $skin1 = Skin::updateOrCreate([
            'product_id' => $product1->id,
        ], [
            'skin_type' => 'Outfit',
            'skin_tier' => 'Common',
        ]);

        $product2 = Product::updateOrCreate([
            'code' => 'SO_15',
        ], [
            'name' => 'Sunset Skin',
            'price_real' => 29.99,
            'product_type' => 'Skin',
            'description' => 'Suitable for kids',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $skin2 = Skin::updateOrCreate([
            'product_id' => $product2->id,
        ], [
            'skin_type' => 'Outfit',
            'skin_tier' => 'Uncommon',
        ]);

        $product3 = Product::updateOrCreate([
            'code' => 'SS_16',
        ], [
            'name' => 'Ducati',
            'price_real' => 30.99,
            'price_game' => 99,
            'price_game_type' => 'Gem',
            'product_type' => 'Skin',
            'description' => 'Used by cool boomers',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $skin3 = Skin::updateOrCreate([
            'product_id' => $product3->id,
        ], [
            'skin_type' => 'Skateboard',
            'skin_tier' => 'Common',
        ]);
    }
}