<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;
use App\Models\GameUser;
use App\Http\Requests\UpdateMasterRequest;
use App\Http\Requests\UpdateGameUserRaceRequest;

class MasterController extends Controller
{
    public function syncAllDataPlayer(UpdateMasterRequest $request)
    {
        $input = $request->validated();
        $gameUserId = $input['game_user_id'];
        $gameUser = GameUser::findOrFail($gameUserId);
    
        if (!$gameUser) {
            return new JsonResource([
                'message' => 'Game User not found',
            ]);
        }

        // Update game user data
        if (!empty($input['game_user']) && is_array($input['game_user']) && !empty($input['game_user'][0])) {
            $gameUserData = $input['game_user'][0];
            $gameUser->update([
                'email' => $gameUserData['email'] ?? $gameUser->email,
                'username' => $gameUserData['username'] ?? $gameUser->username,
                'gold_amount' => $gameUserData['gold_amount'] ?? $gameUser->gold_amount,
                'gem_amount' => $gameUserData['gem_amount'] ?? $gameUser->gem_amount,
                'date_of_birth' => $gameUserData['date_of_birth'] ?? $gameUser->date_of_birth,
                'country' => $gameUserData['country'] ?? $gameUser->country,
                'platform' => $gameUserData['platform'] ?? $gameUser->platform,
                'total_play_time' => $gameUserData['total_play_time'] ?? $gameUser->total_play_time,
                'is_active' => $gameUserData['is_active'] ?? $gameUser->is_active,
                'highest_score' => $gameUserData['highest_score'] ?? $gameUser->highest_score
            ]);
        }

        // Update missions
        if (!empty($input['missions'])) {
            $missions = $input['missions'];
            $requestedMissionIds = collect($missions)->pluck('mission_id');
            
            $existingMissions = $gameUser->missions()
                ->whereIn('mission_id', $requestedMissionIds)
                ->pluck('mission_id');
                
            $missingMissionIds = $requestedMissionIds->diff($existingMissions);
            
            if ($missingMissionIds->isNotEmpty()) {
                return response()->json([
                    'error' => 'Some missions are not associated with this user',
                    'missing_mission_ids' => $missingMissionIds->values(),
                ], 404);
            }
        
            foreach ($missions as $mission) {
                $gameUser->missions()->updateExistingPivot(
                    $mission['mission_id'],
                    [
                        'is_completed' => $mission['is_completed'],
                        'score' => $mission['score'],
                        'updated_at' => now(),
                    ]
                );
            }
        }
        
        // Update achievements
        if (!empty($input['achievements'])) {
            $achievements = $input['achievements'];
            $requestedAchievementIds = collect($achievements)->pluck('achievement_id');

            $existingAchievements = $gameUser->achievements()
                ->whereIn('achievement_id', $requestedAchievementIds)
                ->pluck('achievement_id');
                
            $missingAchievementIds = $requestedAchievementIds->diff($existingAchievements);
            
            if ($missingAchievementIds->isNotEmpty()) {
                return response()->json([
                    'error' => 'Some achievements are not associated with this user',
                    'missing_achievement_ids' => $missingAchievementIds->values(),
                ], 404);
            }
        
            foreach ($achievements as $achievement) {
                $gameUser->achievements()->updateExistingPivot(
                    $achievement['achievement_id'],
                    [
                        'is_completed' => $achievement['is_completed'],
                        'score' => $achievement['score'],
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // Update vouchers
        if (!empty($input['vouchers'])) {
            $claimedVouchers = [];
            foreach ($input['vouchers'] as $voucherData) {
                if (!$gameUser->vouchers()->where('voucher_id', $voucherData['voucher_id'])->exists()) {
                    $gameUser->vouchers()->attach($voucherData['voucher_id']);
                    $claimedVouchers[] = $voucherData['voucher_id'];
                }
            }
        }

        // Update skins
        foreach ($input['skins'] as $skinData) {
            if (!$gameUser->skins()->where('skin_id', $skinData['skin_id'])->exists()) {
                $gameUser->skins()->attach($skinData['skin_id']);
            }
        }

        // Update items
        $items = [];
        foreach ($input['items'] as $itemData) {
            $items[$itemData['item_id']] = ['count' => $itemData['count']];
        }
        $gameUser->items()->sync($items);

    
        return response()->json([
            'message' => 'Player data sync successfully',
            'data' => $gameUser->fresh()->load(['missions', 'achievements', 'vouchers', 'skins', 'items'])
        ], 200);
    }

    public function updateRacePlayer(UpdateGameUserRaceRequest $request)
    {
        $gameUserId = $request->input('game_user_id');
        $missions = $request->input('missions');
        $achievements = $request->input('achievements');
        $gameUserData = $request->input('game_user')[0] ?? null;
    
        $gameUser = GameUser::findOrFail($gameUserId);
        
        $requestedMissionIds = collect($missions)->pluck('mission_id');
        
        $existingMissions = $gameUser->missions()
            ->whereIn('mission_id', $requestedMissionIds)
            ->pluck('mission_id');
            
        $missingMissionIds = $requestedMissionIds->diff($existingMissions);
        
        if ($missingMissionIds->isNotEmpty()) {
            return response()->json([
                'error' => 'Some missions are not associated with this user',
                'missing_mission_ids' => $missingMissionIds->values(),
            ], 404);
        }
    
        foreach ($missions as $mission) {
            $gameUser->missions()->updateExistingPivot(
                $mission['mission_id'],
                [
                    'is_completed' => $mission['is_completed'],
                    'score' => $mission['score'],
                    'updated_at' => now(),
                ]
            );
        }

        $requestedAchievementIds = collect($achievements)->pluck('achievement_id');

        $existingAchievements = $gameUser->achievements()
            ->whereIn('achievement_id', $requestedAchievementIds)
            ->pluck('achievement_id');
            
        $missingAchievementIds = $requestedAchievementIds->diff($existingAchievements);
        
        if ($missingAchievementIds->isNotEmpty()) {
            return response()->json([
                'error' => 'Some achievements are not associated with this user',
                'missing_achievement_ids' => $missingAchievementIds->values(),
            ], 404);
        }
    
        foreach ($achievements as $achievement) {
            $gameUser->achievements()->updateExistingPivot(
                $achievement['achievement_id'],
                [
                    'is_completed' => $achievement['is_completed'],
                    'score' => $achievement['score'],
                    'updated_at' => now(),
                ]
            );
        }

        if ($gameUserData) {
            $updateData = array_filter([
                'total_play_time' => $gameUserData['total_play_time'] ?? null,
                'highest_score' => $gameUserData['highest_score'] ?? null,
            ]);
            
            if (!empty($updateData)) {
                $gameUser->update($updateData);
            }
        }
    
        return response()->json([
            'message' => 'Player after race data updated successfully',
        ], 200);
    }
}