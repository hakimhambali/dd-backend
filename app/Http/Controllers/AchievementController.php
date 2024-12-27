<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Achievement;
use App\Models\GameUser;
use App\Http\Requests\StoreAchievementRequest;
use App\Http\Requests\UpdateAchievementRequest;
use App\Http\Resources\AchievementResource;

class AchievementController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $achievements = Achievement::with('productRewarded')->search(request());
        return AchievementResource::collection($this->paginateOrGet($achievements));
    }

    public function store(StoreAchievementRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['created_by' => auth()->id()]);
        $achievement = Achievement::create($data);

        if ($achievement->is_active == true) {
            $gameUsers = GameUser::all();
            foreach ($gameUsers as $gameUser) {
                DB::table('achievement_game_user')->insert([
                    'achievement_id' => $achievement->id,
                    'game_user_id' => $gameUser->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        return new AchievementResource($achievement->load('productRewarded'));
    }

    public function update(UpdateAchievementRequest $request, $id): JsonResource
    {
        $achievement = Achievement::findOrFail($id);
        $previousIsActive = $achievement->is_active;
        $data = array_merge($request->validated(), ['updated_by' => auth()->id()]);
        $achievement->update($data);
    
        if (!$previousIsActive && $achievement->is_active) {
            $gameUsers = GameUser::all();
            foreach ($gameUsers as $gameUser) {
                DB::table('achievement_game_user')->insert([
                    'achievement_id' => $achievement->id,
                    'game_user_id' => $gameUser->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
        
        if ($previousIsActive && !$achievement->is_active) {
            DB::table('achievement_game_user')
                ->where('achievement_id', $achievement->id)
                ->delete();
        }
    
        return new AchievementResource($achievement->load('productRewarded'));
    }

    public function destroy(Achievement $achievement): Response
    {
        Log::info('Deleting achievement: ', ['achievement' => $achievement]);
        $achievement->update([
            'deleted_by' => auth()->id(),
        ]);
    
        $achievement->delete();
    
        return response()->noContent();
    }

    public function permanentDestroy($id): Response
    {
        try {
            $achievement = Achievement::withTrashed()->findOrFail($id);
            Log::info('Delete achievement Permanently: ', ['achievement' => $achievement]);
        
            $achievement->forceDelete();

            return response()->noContent();

        } catch (ModelNotFoundException $e) {
            Log::error('Achievement not found for permanent deletion', ['id' => $id]);
            return response()->json(['error' => 'Achievement not found'], 404);
        }
        
    }

    public function restore($id): Response
    {
        $achievement = Achievement::withTrashed()->findOrFail($id);
        Log::info('Restore achievement: ', ['achievement' => $achievement]);
    
        if ($achievement->deleted_at) {
            $achievement->restore();
            Log::info('Restored achievement successfully: ', ['id' => $id]);

            return response()->noContent();
        }

        return response()->json(['message' => 'Achievement is already active.'], 400);        
    }
}
