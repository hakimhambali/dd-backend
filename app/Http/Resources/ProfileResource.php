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
            'birth_date' => $this->whenNotNull($this->birth_date?->toDateString()),
            'gender' => $this->whenNotNull($this->gender),
            'nric_passport' => $this->whenNotNull($this->nric_passport),
            'phone_number' => $this->whenNotNull($this->phone_number),
        ];
    }
}
