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
            'price' => $this->price,
            'product_type' => $this->product_type,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
            'updated_at' => $this->updated_at->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
            'deleted_at' => optional($this->deleted_at)->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
        ];
    }
}