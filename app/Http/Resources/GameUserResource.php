<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameUserResource extends JsonResource
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
            'email' => $this->email,
            'username' => $this->username,
            'gold_amount' => $this->gold_amount,
            'gem_amount' => $this->gem_amount,
            'date_of_birth' => $this->date_of_birth,
            'country' => $this->country,
            'platform' => $this->platform,
            'register_date' => $this->register_date,
            'total_play_time' => $this->total_play_time,
            'is_active' => $this->is_active,
            'highest_score' => $this->highest_score,
            'created_at' => $this->created_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s') : null,
        ];
    }
}