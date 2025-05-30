<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

    public function update(UpdateTerrainRequest $request, $id)
    {
        $input = $request->validated();
        $terrain = Terrain::findOrFail($id);
        $defaultTerrains = Terrain::where('is_default', true);

        if ($terrain->is_default === true && $input['is_default'] === false) {
            if ($defaultTerrains->count() > 1) {
                $data = array_merge($input, ['updated_by' => auth()->id()]);
                $terrain->update($data);
    
                Log::info('Update terrain completed: ', ['terrain' => $terrain]);
                return TerrainResource::make($terrain);
            } else {        

                return TerrainResource::make($terrain)->additional([
                    'error' => 'Updated failed',
                    'errors' => ['name' => ['Terrain cannot update status. Must have at least one default terrain.']]
                ])->response()->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
                
            }
        } else {
            $data = array_merge($input, ['updated_by' => auth()->id()]);
            $terrain->update($data);

            Log::info('Update terrain completed: ', ['terrain' => $terrain]);
            return TerrainResource::make($terrain);
        }
    }

    public function destroy(Terrain $terrain): Response
    {
        $defaultTerrains = Terrain::where('is_default', '=', true);
        
        if ($defaultTerrains->count() > 1) {
            Log::info('Deleting terrain: ', ['terrain' => $terrain]);

            $terrain->update([
                'deleted_by' => auth()->id(),
            ]);
            $terrain->delete();

            return response()->noContent();

        } else {

            $defaultTerrain = $defaultTerrains->first();
            if ($defaultTerrain && $defaultTerrain->id === $terrain->id) {
                Log::error('Terrain cannot be deleted. Selected terrain is the only default terrain', ['id' => $terrain->id]);
                
                return response(
                    ['message' => 'Terrain is default and cannot be deleted. Must have at least one default terrain.'], 
                    Response::HTTP_UNPROCESSABLE_ENTITY // 422 status code
                );

            } else {
                Log::info('Deleting terrain: ', ['terrain' => $terrain]);

                $terrain->update([
                    'deleted_by' => auth()->id(),
                ]);
                $terrain->delete();

                return response()->noContent();
            }
        }

    }

    public function permanentDestroy($id): Response
    {
        try {
            $terrain = Terrain::withTrashed()->findOrFail($id);
            Log::info('Delete Terrain Permanently: ', ['terrain' => $terrain]);
        
            $terrain->forceDelete();

            return response()->noContent();

        } catch (ModelNotFoundException $e) {
            Log::error('Terrain not found for permanent deletion', ['id' => $id]);
            return response()->json(['error' => 'Terrain not found'], 404);
        }
        
    }

    public function restore($id): Response
    {
        $terrain = Terrain::withTrashed()->findOrFail($id);
        Log::info('Restore Terrain: ', ['terrain' => $terrain]);
    
        if ($terrain->deleted_at) {
            $terrain->restore();
            Log::info('Restored terrain successfully: ', ['id' => $id]);

            return response()->noContent();
        }

        return response()->json(['message' => 'Terrain is not deleted therefore cannot be restored.'], 400);        
    }
}
