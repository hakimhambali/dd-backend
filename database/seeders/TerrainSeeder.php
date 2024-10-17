<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Terrain;

class TerrainSeeder extends Seeder
{
    public function run(): void
    {
        $terrain1 = Terrain::updateOrCreate(
            ['name' => 'Melaka City'],
            [
                'description' => 'Melaka is known for its rich history, heritage, and architecture. Its city was one of the busiest cities in the world in the old days and remains an iconic heritage site today.',
                'is_default' => 1,
                'is_active' => 1,
                'created_by' => 1,
            ]
        );

        $terrain2 = Terrain::updateOrCreate(
            ['name' => 'Titiwangsa Mountains'],
            [
                'description' => 'The Titiwangsa Mountains form the backbone of Peninsular Malaysia, known for their challenging terrain and lush rainforest.',
                'is_default' => 0,
                'is_active' => 1,
                'created_by' => 1,
            ]
        );

        $terrain3 = Terrain::updateOrCreate(
            ['name' => 'Langkawi Archipelago'],
            [
                'description' => 'Langkawi is a group of 99 islands known for its stunning beaches, clear waters, and diverse wildlife, making it a top tourist destination.',
                'is_default' => 0,
                'is_active' => 1,
                'created_by' => 1,
            ]
        );
    }
}
