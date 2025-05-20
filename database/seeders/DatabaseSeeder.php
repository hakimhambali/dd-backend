<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            GameUserSeeder::class,
            CurrencyHistorySeeder::class,
            CurrencyProductSeeder::class,
            ItemProductSeeder::class,
            SkinProductSeeder::class,
            VoucherSeeder::class,
            TransactionHistorySeeder::class,
            MissionSeeder::class,
            AchievementSeeder::class,
            TerrainSeeder::class,
            // AchievementGameUserSeeder::class
        ]);
    }
}