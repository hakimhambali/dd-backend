<?php

namespace Database\Seeders;

use App\Models\Religion;
use Illuminate\Database\Seeder;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Religion::NAMES as $id => $name) {
            Religion::updateOrCreate(['id' => $id], ['name' => $name]);
        }
    }
}
