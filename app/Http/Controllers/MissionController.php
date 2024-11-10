<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use App\Models\Mission;
use App\Http\Requests\StoreMissionRequest;
use App\Http\Requests\UpdateMissionRequest;
use App\Http\Resources\MissionResource;
use App\Models\GameUser;
use App\Http\Resources\GameUserResource;

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
            DB::table('mission_game_user')
                ->where('mission_id', $mission->id)
                ->delete();
        }
    
        return new MissionResource($mission->load('productRewarded'));
    }

    public function destroy(Mission $mission): Response
    {
        $mission->update([
            'deleted_by' => auth()->id(),
        ]);
    
        $mission->delete();
    
        return response()->noContent();
    }
}
