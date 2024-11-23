<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GameUserSkinResource extends JsonResource
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
            'skins' => SkinResource::collection($this->whenLoaded('skins')),
        ];
    }
}