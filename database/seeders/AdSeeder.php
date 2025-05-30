<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ad;

class AdSeeder extends Seeder
{
    public function run(): void
    {
        $bulks = [
            ['skips' => 10,   'real_price' => 1.90, 'created_by' => 1],
            ['skips' => 100,  'real_price' => 17.00, 'created_by' => 1],
            ['skips' => 1000, 'real_price' => 150.00, 'created_by' => 1],
        ];

        foreach ($bulks as $bulk) {
            Ad::updateOrCreate(
                ['skips' => $bulk['skips']],
                $bulk
            );
        }
    }
}
