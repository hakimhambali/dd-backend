<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Mission;
use App\Http\Requests\StoreMissionRequest;
use App\Http\Requests\UpdateMissionRequest;
use App\Http\Resources\MissionResource;

class MissionController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $missions = Mission::with('productRewarded')->search(request());
        return MissionResource::collection($this->paginateOrGet($missions));
    }

    public function store(StoreMissionRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['created_by' => auth()->id()]);
        $mission = Mission::create($data);
        return new MissionResource($mission->load('productRewarded'));
    }

    public function update(UpdateMissionRequest $request, $id): JsonResource
    {
        $mission = Mission::findOrFail($id);
        $previousIsActive = $mission->is_active;
        $data = array_merge($request->validated(), ['updated_by' => auth()->id()]);
        $mission->update($data);
        
        if ($previousIsActive && !$mission->is_active) {
            DB::table('game_user_mission')
                ->where('mission_id', $mission->id)
                ->delete();
        }
    
        return new MissionResource($mission->load('productRewarded'));
    }

    public function destroy(Mission $mission): Response
    {
        Log::info('Deleting mission: ', ['mission' => $mission]);

        $mission->update([
            'deleted_by' => auth()->id(),
        ]);
    
        $mission->delete();
    
        return response()->noContent();
    }

    public function permanentDestroy($id): Response
    {
        try {
            $mission = Mission::withTrashed()->findOrFail($id);
            Log::info('Delete mission Permanently: ', ['mission' => $mission]);
        
            $mission->forceDelete();

            return response()->noContent();

        } catch (ModelNotFoundException $e) {
            Log::error('Mission not found for permanent deletion', ['id' => $id]);
            return response()->json(['error' => 'Mission not found'], 404);
        }
        
    }

    public function restore($id): Response
    {
        $mission = Mission::withTrashed()->findOrFail($id);
        Log::info('Restore mission: ', ['mission' => $mission]);
    
        if ($mission->deleted_at) {
            $mission->restore();
            Log::info('Restored mission successfully: ', ['id' => $id]);

            return response()->noContent();
        }

        return response()->json(['message' => 'Mission is already active.'], 400);        
    }
}
