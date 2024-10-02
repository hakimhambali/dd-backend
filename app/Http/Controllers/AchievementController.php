<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Achievement;
use App\Http\Requests\StoreAchievementRequest;
use App\Http\Requests\UpdateAchievementRequest;
use App\Http\Resources\AchievementResource;

class AchievementController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        Log::info("AchievementControllerindex");
        $achievements = Achievement::search(request());
        return AchievementResource::collection($this->paginateOrGet($achievements));
    }

    public function store(StoreAchievementRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['created_by' => auth()->id()]);
        $achievement = Achievement::create($data);
        return new AchievementResource($achievement);
    }

    public function destroy(Achievement $achievement): Response
    {
        $achievement->delete();
        return response()->noContent();
    }
}
