<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Models\GameUser;
use App\Http\Requests\StoreGameUserRequest;
use App\Http\Requests\UpdateGameUserRequest;
use App\Http\Requests\UpdateGameUserPasswordRequest;
use App\Http\Requests\StoreGameUserRewardRequest;
use App\Http\Resources\GameUserResource;
use App\Http\Resources\GameUserSkinResource;
use App\Http\Resources\GameUserItemResource;

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

    public function updatePassword(UpdateGameUserPasswordRequest $request)
    {
        $authenticatedUser = Auth::guard('game')->user();
        Log::info('authenticatedUser: ', ['authenticatedUserData' => $authenticatedUser]);

        $gameUser = GameUser::findOrFail($authenticatedUser->id);

        $input = $request->validated();

        if (!$gameUser || !password_verify($input['current_password'], $gameUser->password)) {
            return response()->json(['message' => 'Incorrect password.'], 403);
        }

        if (!$gameUser || password_verify($input['new_password'], $gameUser->password)) {
            return response()->json(['message' => 'New password must be different from current password.'], 403);
        }

        $gameUser->update([
            'password' => bcrypt($input['new_password'])
        ]);

        return response()->json([
            'message' => 'Password updated successfully.',
            'user' => new GameUserResource($gameUser),
        ], 200);
    }

    public function destroy($id): Response
    {
        $gameUser = GameUser::findOrFail($id);
        Log::info('Deleting GameUser: ', ['gameUser' => $gameUser]);
    
        $gameUser->update([
            'deleted_by' => auth()->id(),
        ]);
        $gameUser->delete();
    
        return response()->noContent();
    }

    public function permanentDestroy($id): Response
    {
        try {
            $gameUser = GameUser::withTrashed()->findOrFail($id);
            Log::info('Delete GameUser Permanently: ', ['gameUser' => $gameUser]);
        
            $gameUser->forceDelete();

            return response()->noContent();

        } catch (ModelNotFoundException $e) {
            Log::error('GameUser not found for permanent deletion', ['id' => $id]);
            return response()->json(['error' => 'GameUser not found'], 404);
        }
        
    }

    public function restore($id): Response
    {
        $gameUser = GameUser::withTrashed()->findOrFail($id);
        Log::info('Restore GameUser: ', ['gameUser' => $gameUser]);
    
        if ($gameUser->deleted_at) {
            $gameUser->restore();
            Log::info('Restored GameUser successfully: ', ['id' => $id]);

            return response()->noContent();
        }

        return response()->json(['message' => 'GameUser is already active.'], 400);        
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

        $items = [];
        foreach ($validated['items'] as $itemData) {
            $items[$itemData['item_id']] = ['count' => $itemData['count']];
        }
        $gameUser->items()->sync($items);

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

    public function gameUserItems() 
    {
        Log::info("GameUserController-gameUserItems");
        $authUser = Auth::guard('game')->user();
        Log::info('Authenticated User: ', ['authenticatedUserData' => $authUser]);

        if (!$authUser) {
            return response()->json(['message' => 'User is not authenticated.'], 401);
        }
        
        if (!GameUser::find($authUser->id)) {
            return new JsonResource([
                'message' => 'Game User not found',
            ]);
        } else {
            $gameUser = GameUser::with('items')->findOrFail($authUser->id);
        }
        
        return new GameUserItemResource($gameUser);
    }

    public function gameUserSkins() 
    {
        $authUser = Auth::guard('game')->user();
        Log::info('Authenticated User: ', ['authenticatedUserData' => $authUser]);

        if (!GameUser::find($authUser->id)) {
            return new JsonResource([
                'message' => 'Game User not found',
            ]);
        } else {
            $gameUser = GameUser::with('skins')->findOrFail($authUser->id);
        }

        return new GameUserSkinResource($gameUser);
    }
}
