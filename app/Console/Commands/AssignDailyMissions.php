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
    protected $description = 'Assign 21 random missions to each game user weekly';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all active missions
        $activeMissions = Mission::where('is_active', true)->get();

        // Ensure there are enough active missions
        if ($activeMissions->count() < 21) {
            $this->error('Not enough active missions to assign.');
            return;
        }

        // Delete all mission assignments from last week
        DB::table('game_user_mission')
            ->whereDate('created_at', '<=', Carbon::now()->subWeek())
            ->delete();

        // Get all game users
        $gameUsers = GameUser::all();

        foreach ($gameUsers as $gameUser) {
            // Get the user’s assigned missions for today
            $assignedThisWeek = DB::table('game_user_mission')
                ->where('game_user_id', $gameUser->id)
                ->whereDate('created_at', '>=', Carbon::now()->startOfWeek())
                ->pluck('mission_id');

            // If they already have 21 missions for 7 days, skip
            if ($assignedThisWeek->count() >= 21) {
                continue;
            }

            // Pick 21 random missions that haven't been assigned today
            $missionsToAssign = $activeMissions
                ->whereNotIn('id', $assignedThisWeek)
                ->random(21 - $assignedThisWeek->count());

            // Assign the missions to the user
            $data = [];
            foreach ($missionsToAssign as $mission) {
                $data[] = [
                    'mission_id' => $mission->id,
                    'game_user_id' => $gameUser->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            DB::table('game_user_mission')->insert($data);

            // $this->info("Assigned missions to user: {$gameUser->username}");
        }

        $this->info('Mission assignment completed.');
    }
}
