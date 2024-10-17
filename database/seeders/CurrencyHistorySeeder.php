<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CurrencyHistory;

class CurrencyHistorySeeder extends Seeder
{
    public function run(): void
    {
        $currencyhistory1 = CurrencyHistory::updateOrCreate([
            'game_user_id' => 1,
            'amount' => 100,
            'currency_type' => 'Gold',
            'description' => 'Earn from completing mission',
        ]);

        $currencyhistory2 = CurrencyHistory::updateOrCreate([
            'game_user_id' => 1,
            'amount' => 50,
            'currency_type' => 'Gem',
            'description' => 'Earn from completing achievement',
        ]);

        $currencyhistory3 = CurrencyHistory::updateOrCreate([
            'game_user_id' => 2,
            'amount' => 200,
            'currency_type' => 'Gold',
            'description' => 'Earn from winning tournament',
        ]);
    }
}
