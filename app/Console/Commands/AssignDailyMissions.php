<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Mission;
use App\Models\GameUser;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssignDailyMissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'missions:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign 3 random missions to each game user daily';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all active missions
        $activeMissions = Mission::where('is_active', true)->get();

        // Ensure there are enough active missions
        if ($activeMissions->count() < 3) {
            $this->error('Not enough active missions to assign.');
            return;
        }

        // Get all game users
        $gameUsers = GameUser::all();

        foreach ($gameUsers as $gameUser) {
            // Get the user’s assigned missions for today
            $assignedMissionsToday = DB::table('mission_game_user')
                ->where('game_user_id', $gameUser->id)
                ->whereDate('created_at', Carbon::today())
                ->pluck('mission_id');

            // If they already have 3 missions for today, skip
            if ($assignedMissionsToday->count() >= 3) {
                continue;
            }

            // Pick 3 random missions that haven't been assigned today
            $missionsToAssign = $activeMissions
                ->whereNotIn('id', $assignedMissionsToday)
                ->random(3 - $assignedMissionsToday->count());

            // Assign the missions to the user
            foreach ($missionsToAssign as $mission) {
                DB::table('mission_game_user')->insert([
                    'mission_id' => $mission->id,
                    'game_user_id' => $gameUser->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            $this->info("Assigned missions to user: {$gameUser->username}");
        }

        $this->info('Mission assignment completed.');
    }
}
