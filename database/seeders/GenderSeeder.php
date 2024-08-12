<?php

namespace Database\Seeders;

use App\Models\Gender;
use Illuminate\Database\Seeder;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Gender::NAMES as $id => $name) {
            Gender::updateOrCreate(['id' => $id], ['name' => $name]);
        }
    }
}
