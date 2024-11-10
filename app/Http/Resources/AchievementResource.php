<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AchievementResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'max_score' => $this->max_score,
            'reward_type' => $this->reward_type,
            'reward_value' => $this->reward_value,
            'is_active' => $this->is_active,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s') : null,
            'product_rewarded' => $this->productRewarded ? new ProductResource($this->productRewarded) : null,
            'product_rewarded_id' => $this->product_rewarded_id,
        ];
    }
}