<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\GameUser;
use App\Http\Requests\StoreGameUserRequest;
use App\Http\Requests\UpdateGameUserRequest;
use App\Http\Resources\GameUserResource;
use App\Http\Requests\StoreGameUserRewardRequest;

class GameUserController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $gameusers = GameUser::query();
        $gameusers = $gameusers->search(request());
        return GameUserResource::collection($this->paginateOrGet($gameusers));
    }

    public function show($id): JsonResource
    {
        $gameUser = GameUser::find($id);
    
        if (!$gameUser) {
            return new JsonResource([
                'message' => 'Game User not found',
            ]);
        }
    
        return new GameUserResource($gameUser);
    }

    // public function show(GameUser $gameUser)
    // {
    //     return new GameUserResource($gameUser);
    // return GameUserResource::make($gameUser);
    // }

    public function store(StoreGameUserRequest $request): JsonResource
    {
        $gameUser = GameUser::create($request->validated());
        return new GameUserResource($gameUser);
    }

    public function update(UpdateGameUserRequest $request, $id): JsonResource
    {
        $gameUser = GameUser::findOrFail($id);
        $gameUser->update($request->validated());
        return new GameUserResource($gameUser);
    }

    public function destroy(GameUser $gameUser): Response
    {
        $gameUser->update([
            'deleted_by' => auth()->id(),
        ]);
        $gameUser->delete();
    
        return response()->noContent();
    }

    public function claimReward(StoreGameUserRewardRequest $request)
    {
        $validated = $request->validated();
        $gameUserData = $request->input('game_user')[0] ?? null;
        $gameUser = GameUser::findOrFail($validated['game_user_id']);

        foreach ($validated['skins'] as $skinData) {
            if (!$gameUser->skins()->where('skin_id', $skinData['skin_id'])->exists()) {
                $gameUser->skins()->attach($skinData['skin_id']);
            }
        }

        if ($gameUserData) {
            $updateData = array_filter([
                'gold_amount' => $gameUserData['gold_amount'] ?? null,
                'gem_amount' => $gameUserData['gem_amount'] ?? null,
            ]);
            
            if (!empty($updateData)) {
                $gameUser->update($updateData);
            }
        }

        return response()->json([
            'message' => 'Player claim reward successfully',
        ], 200);
    }
}
