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
            'description' => 'Earn as finish mission collect gold coins 100',
        ]);

        $currencyhistory2 = CurrencyHistory::updateOrCreate([
            'game_user_id' => 1,
            'amount' => 50,
            'currency_type' => 'Gem',
            'description' => 'Earn from completing side quests',
        ]);

        $currencyhistory3 = CurrencyHistory::updateOrCreate([
            'game_user_id' => 2,
            'amount' => 200,
            'currency_type' => 'Gold',
            'description' => 'Bonus for leveling up',
        ]);
    }
}
