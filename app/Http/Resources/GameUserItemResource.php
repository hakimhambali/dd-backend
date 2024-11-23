<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameUserItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'gameusers' => GameUserResource::collection($this->whenLoaded('gameusers')),
            'items' => ItemResource::collection($this->whenLoaded('items')),
        ];
    }
}