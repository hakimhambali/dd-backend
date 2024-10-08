<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CurrencyHistoryResource extends JsonResource
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
            'amount' => $this->amount,
            'currency_type' => $this->currency_type,
            'description' => $this->description,
            'created_at' => $this->created_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s') : null,
            'game_user' => GameUserResource::make($this->whenLoaded('game_user')),
        ];
    }
}