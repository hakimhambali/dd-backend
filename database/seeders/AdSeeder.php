<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $bulks = [
            ['skips' => 10,   'price_real' => 1.90, 'created_by' => 1],
            ['skips' => 100,  'price_real' => 17.00, 'created_by' => 1],
            ['skips' => 1000, 'price_real' => 150.00, 'created_by' => 1],
        ];

        foreach ($bulks as $bulk) {
            Ad::updateOrCreate(
                ['skips' => $bulk['skips']],
                $bulk
            );
        }
    }
}
