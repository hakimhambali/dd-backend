<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Terrain;
use App\Http\Requests\StoreTerrainRequest;
use App\Http\Requests\UpdateTerrainRequest;
use App\Http\Resources\TerrainResource;

class TerrainController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        Log::info("TerrainControllerindex");
        $terrains = Terrain::search(request());
        return TerrainResource::collection($this->paginateOrGet($terrains));
    }

    public function store(StoreTerrainRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['created_by' => auth()->id()]);
        $terrain = Terrain::create($data);
        return new TerrainResource($terrain);
    }

    public function destroy(Terrain $terrain): Response
    {
        $terrain->delete();
        return response()->noContent();
    }
}
