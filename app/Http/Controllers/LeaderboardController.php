<?php

namespace App\Http\Controllers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Traits\PaginateTrait;
use Illuminate\Support\Facades\Log;

use App\Models\Leaderboard;
use App\Http\Resources\LeaderboardResource;

class LeaderboardController extends Controller
{
    use PaginateTrait;

    public function index(): AnonymousResourceCollection
    {
        $leaderboards = Leaderboard::with('game_user');
        $leaderboards = $leaderboards->search(request());
        return LeaderboardResource::collection($this->paginateOrGet($leaderboards));
    }
}
