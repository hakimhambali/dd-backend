<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'full_name' => $this->full_name,
            'staff_no' => $this->staff_no,
            'nric_passport' => $this->nric_passport,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
            'updated_at' => $this->updated_at->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
            'deleted_at' => optional($this->deleted_at)->setTimeZone('Asia/Kuala_Lumpur')->toDateTimeString(),
        ];
    }
}
