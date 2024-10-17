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

class GameUserController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $gameusers = GameUser::query();
        $gameusers = $gameusers->search(request());
        return GameUserResource::collection($this->paginateOrGet($gameusers));
    }
    
    // public function index(): AnonymousResourceCollection
    // {
    //     $gameusers = GameUser::all();
    //     return GameUserResource::collection($gameusers);
    // }

    public function show(GameUser $gameUser): JsonResource
    {
        return new GameUserResource($gameUser);
    }

    // public function store(StoreGameUserRequest $request): JsonResource
    // {
    //     $input = $request->validated();
    
    //     $gameuser = GameUser::create($input);
    
    //     $gameuser->create([
    //         'email' => $input['email'],
    //         'password' => $input['password'],
    //         'username' => $input['username'],
    //         'date_of_birth' => $input['date_of_birth'],
    //         'country' => $input['country'],
    //         'platform' => $input['platform'],
    //         'register_date' => $input['register_date'],
    //     ]);
    
    //     return GameUser::make($gameuser);
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
}
