<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

use App\Models\Mission;
use App\Http\Resources\MissionResource;
use App\Models\GameUser;

class GameUserMissionController extends Controller
{
    public function assignMissionsPlayer($game_user_id): JsonResource
    {
        Log::info("assignPlayer");
        $gameUser = GameUser::find($game_user_id);
    
        if (!$gameUser) {
            return new JsonResource([
                'message' => 'Game User not found',
            ]);
        }

        $missions = Mission::all();

        if ($missions->count() < 30) {
            return new JsonResource([
                'message' => 'Not enough missions to assign',
            ]);
        }
    
        $uniqueMissions = $missions->random(30);

        $missionData = $uniqueMissions->mapWithKeys(function ($mission) {
            return [
                $mission->id => [
                    'is_completed' => false,
                    'score' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
            ];
        })->toArray();
    
        // $gameUser->missions()->syncWithoutDetaching($uniqueMissions->pluck('id')->toArray());
        // $gameUser->missions()->sync($uniqueMissions->pluck('id')->toArray());
        $gameUser->missions()->sync($missionData);
    
        return new JsonResource([
            'message' => 'Missions assigned successfully',
            'created_at' => Carbon::now(),
            'game_user' => $gameUser->only(['id', 'username']),
            'missions' => MissionResource::collection($uniqueMissions),
        ]);
    }
}
