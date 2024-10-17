<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        // Voucher 1: Promo Raya
        $voucher1 = Voucher::updateOrCreate([
            'name' => 'Promo Raya',
        ], [
            'description' => 'Promo Raya comes again!',
            'min_price' => 19.99,
            'is_percentage_flatprice' => 1,  // 1 for percentage, 0 for flat price
            'discount_value' => 50,          // Assuming 50% off
            'expired_time' => 30,            // Voucher expiry duration in days
            'max_claim' => 1000,             // Max number of times this voucher can be claimed
            'start_date' => '2024-10-01 00:00:00',
            'end_date' => '2024-10-31 23:59:00',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        // Voucher 2: Winter Sale
        $voucher2 = Voucher::updateOrCreate([
            'name' => 'Winter Sale',
        ], [
            'description' => 'Get ready for winter with great deals!',
            'min_price' => 29.99,
            'is_percentage_flatprice' => 1,  // 1 for percentage
            'discount_value' => 30,          // 30% off
            'expired_time' => 15,            // Voucher expiry duration in days
            'max_claim' => 500,
            'start_date' => '2024-12-01 00:00:00',
            'end_date' => '2024-12-31 23:59:00',
            'is_active' => 1,
            'created_by' => 1,
        ]);

        // Voucher 3: New Year Special
        $voucher3 = Voucher::updateOrCreate([
            'name' => 'New Year Special',
        ], [
            'description' => 'Celebrate the new year with this special discount!',
            'min_price' => 49.99,
            'is_percentage_flatprice' => 0,  // 0 for flat price
            'discount_value' => 10,          // Flat $10 off
            'expired_time' => 7,             // Voucher expiry duration in days
            'max_claim' => 300,
            'start_date' => '2025-01-01 00:00:00',
            'end_date' => '2025-01-07 23:59:00',
            'is_active' => 1,
            'created_by' => 1,
        ]);
    }
}