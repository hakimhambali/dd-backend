<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionHistory;
use Carbon\Carbon;

class TransactionHistorySeeder extends Seeder
{
    public function run(): void
    {
        $transactionhistory1 = TransactionHistory::updateOrCreate([
            'product_id' => 2,
            'game_user_id' => 1,
            'buy_price' => 100.18,
            'transaction_date' => Carbon::now(),
            'voucher_earned_id' => 1,
            'voucher_used_id' => null,
            'platform' => 'Ios',
        ]);

        $transactionhistory2 = TransactionHistory::updateOrCreate([
            'product_id' => 1,
            'game_user_id' => 1,
            'buy_price' => 81.72,
            'transaction_date' => Carbon::now()->subDays(1),
            'voucher_earned_id' => 2,
            'voucher_used_id' => 1,
            'platform' => 'Android',
        ]);

        $transactionhistory3 = TransactionHistory::updateOrCreate([
            'product_id' => 3,
            'game_user_id' => 2,
            'buy_price' => 161.82,
            'transaction_date' => Carbon::now()->subDays(2),
            'voucher_earned_id' => 3,
            'voucher_used_id' => 2,
            'platform' => 'Huawei',
        ]);
    }
}
