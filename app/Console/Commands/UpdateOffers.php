<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateOffers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update 3 random offers from product every day for 50% off, 3 random offers every week for 30% off and 3 random offers every month for 10% off';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now();
        $products = Product::where('is_active', true)->inRandomOrder()->get();

        if ($products->count() < 9) {
            $this->error('Not enough active products to assign unique offers.');
            return;
        }

        $now = now();
        $offersToInsert = collect();
        $usedProductIds = collect();

        $discountPrice = fn($price, $percent) => round($price * ((100 - $percent) / 100), 2);

        // === Daily Offers ===
        $daily = $products->whereNotIn('id', $usedProductIds)->take(3);
        Offer::where('discount_percent', 50)->delete();

        foreach ($daily as $product) {
            $usedProductIds->push($product->id);
            $offersToInsert->push([
                'discount_percent' => 50,
                'price_real_before_discount' => $product->price_real,
                'price_real_after_discount' => $discountPrice($product->price_real, 50),
                'product_id' => $product->id,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // === Weekly Offers ===
        if ($today->isSunday() || !Offer::where('discount_percent', 30)->exists()) {
            $weekly = $products->whereNotIn('id', $usedProductIds)->take(3);
            Offer::where('discount_percent', 30)->delete();

            foreach ($weekly as $product) {
                $usedProductIds->push($product->id);
                $offersToInsert->push([
                    'discount_percent' => 30,
                    'price_real_before_discount' => $product->price_real,
                    'price_real_after_discount' => $discountPrice($product->price_real, 30),
                    'product_id' => $product->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // === Monthly Offers ===
        if ($today->isSameDay($today->copy()->startOfMonth()) || !Offer::where('discount_percent', 10)->exists()) {
            $monthly = $products->whereNotIn('id', $usedProductIds)->take(3);
            Offer::where('discount_percent', 10)->delete();

            foreach ($monthly as $product) {
                $offersToInsert->push([
                    'discount_percent' => 10,
                    'price_real_before_discount' => $product->price_real,
                    'price_real_after_discount' => $discountPrice($product->price_real, 10),
                    'product_id' => $product->id,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Insert all collected offers
        DB::table('offers')->insert($offersToInsert->toArray());

        $this->info('Offers updated successfully: ' . $offersToInsert->count() . ' offers created.');
    }
}
