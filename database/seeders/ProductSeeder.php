<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Skin;
use App\Models\Item;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $product1 = Product::updateOrCreate([
            'code' => 'SK_1',
        ], [
            'name' => 'Summer Skin',
            'price' => 19.99,
            'product_type' => 'Skin',
            'description' => 'Fresh look summer skin',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $skin1 = Skin::updateOrCreate([
            'product_id' => $product1->id,
        ], [
            'skin_type' => 'Shirt',
        ]);

        $product2 = Product::updateOrCreate([
            'code' => 'SK_2',
        ], [
            'name' => 'Sunset Skin',
            'price' => 29.99,
            'product_type' => 'Skin',
            'description' => 'Suitable for kids',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $skin2 = Skin::updateOrCreate([
            'product_id' => $product2->id,
        ], [
            'skin_type' => 'Outfit',
        ]);

        $product3 = Product::updateOrCreate([
            'code' => 'IT_3',
        ], [
            'name' => 'Ducati',
            'price' => 30.99,
            'product_type' => 'Item',
            'description' => 'Used by cool boomers',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        $item3 = Item::updateOrCreate([
            'product_id' => $product3->id,
        ], [
            'item_type' => 'Vehicle',
        ]);
    }
}