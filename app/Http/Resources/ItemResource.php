<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
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
            'product' => ProductResource::make($this->whenLoaded('product')),
            'item_type' => $this->item_type,
            'created_at' => $this->created_at->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
            'updated_at' => $this->updated_at->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
            'deleted_at' => optional($this->deleted_at)->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
        ];
    }
}