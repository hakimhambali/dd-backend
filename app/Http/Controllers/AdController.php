<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\Ad;
use App\Http\Requests\StoreAdRequest;
use App\Http\Requests\UpdateAdRequest;
use App\Http\Resources\AdResource;

class AdController extends Controller
{
    use PaginateTrait;

public function index(): AnonymousResourceCollection
{
    Log::info("AdController@index called");

    $ads = Ad::search(request());

    $response = AdResource::collection($this->paginateOrGet($ads));

    // Convert the response to array and then log (without affecting performance in production)
    if (config('app.debug')) {
        Log::info('AdController@index Response Data:', [
            'data' => $response->resolve(request())
        ]);
    }

    return $response;
}

    public function store(StoreAdRequest $request): JsonResource
    {
        $data = array_merge($request->validated(), ['created_by' => auth()->id()]);
        $existsAd = Ad::where('skips', $data['skips'])->exists();

        if ($existsAd) {
            return response()->json(
                ['message' => 'Ad skips already exist.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $ad = Ad::create($data);
        return new AdResource($ad);
    }

    public function update(UpdateAdRequest $request, $id)
    {
        $input = $request->validated();
        $ad = Ad::findOrFail($id);

        $data = array_merge($input, ['updated_by' => auth()->id()]);
        $existsAd = Ad::where('skips', $data['skips'])->where('id', '!=', $id)->exists();

        if ($existsAd) {
            return response()->json(
                ['message' => 'Ad skips already exist.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }
        $ad->update($data);

        Log::info('Update ad completed: ', ['ad' => $ad]);
        return AdResource::make($ad);
    }

    public function destroy(Ad $ad): Response
    {
        Log::info('Deleting ad: ', ['ad' => $ad]);

        $ad->update([
            'deleted_by' => auth()->id(),
        ]);
        $ad->delete();

        return response()->noContent();
    }

    public function permanentDestroy($id): Response
    {
        try {
            $ad = Ad::withTrashed()->findOrFail($id);
            Log::info('Delete Ad Permanently: ', ['ad' => $ad]);
        
            $ad->forceDelete();

            return response()->noContent();

        } catch (ModelNotFoundException $e) {
            Log::error('Ad not found for permanent deletion', ['id' => $id]);
            return response()->json(['error' => 'Ad not found'], 404);
        }
    }

    public function restore($id): Response
    {
        $ad = Ad::withTrashed()->findOrFail($id);
        Log::info('Restore Ad: ', ['ad' => $ad]);
    
        if ($ad->deleted_at) {
            $ad->restore();
            Log::info('Restored ad successfully: ', ['id' => $id]);

            return response()->noContent();
        }

        return response()->json(['message' => 'Ad is not deleted therefore cannot be restored.'], 400);        
    }
}
