<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GameUser;
use App\Models\Leaderboard;

class UpdateLeaderboards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboards:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the leaderboards with the top 10 highest scoring players';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $players  = GameUser::orderBy('highest_score', 'desc')
            ->get(['id', 'highest_score']);

        Leaderboard::truncate();

        foreach ($players  as $player) {
            Leaderboard::create([
                'game_user_id' => $player->id,
                'score' => $player->highest_score,
            ]);
        }

        $this->info('Leaderboards updated successfully.');
    }
}
