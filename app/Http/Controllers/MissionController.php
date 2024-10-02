<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Mission;
use App\Http\Requests\StoreMissionRequest;
use App\Http\Requests\UpdateMissionRequest;
use App\Http\Resources\MissionResource;

class MissionController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        Log::info("MissionControllerindex");
        $missions = Mission::search(request());
        return MissionResource::collection($this->paginateOrGet($missions));
    }

    public function store(StoreMissionRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['created_by' => auth()->id()]);
        $mission = Mission::create($data);
        return new MissionResource($mission);
    }

    public function destroy(Mission $mission): Response
    {
        $mission->delete();
        return response()->noContent();
    }
}
