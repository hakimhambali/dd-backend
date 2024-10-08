<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'game_user_id' => $this->game_user_id,
            'score' => $this->score,
            'created_at' => $this->created_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'game_user' => GameUserResource::make($this->whenLoaded('game_user')),
        ];
    }
}