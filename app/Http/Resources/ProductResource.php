<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'code' => $this->code,
            'name' => $this->name,
            'price_real' => $this->price_real,
            'price_game' => $this->price_game,
            'price_game_type' => $this->price_game_type,
            'product_type' => $this->product_type,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'items' => ItemResource::collection($this->whenLoaded('items')),
            'skin' => $this->whenLoaded('skin') ? new SkinResource($this->whenLoaded('skin')) : null,
            'currency' => $this->whenLoaded('currency') ? new CurrencyResource($this->whenLoaded('currency')) : null,
        ];
    }
}