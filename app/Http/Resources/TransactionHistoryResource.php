<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionHistoryResource extends JsonResource
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
            'paid_price_real' => $this->paid_price_real,
            'transaction_date' => $this->transaction_date,
            'platform' => $this->platform,
            'created_at' => $this->created_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s'),
            'deleted_at' => $this->deleted_at ? $this->deleted_at->timezone('Asia/Kuala_Lumpur')->format('Y-m-d H:i:s') : null,
            'game_user' => GameUserResource::make($this->whenLoaded('game_user')),
            'product' => ProductResource::make($this->whenLoaded('product')),
            'voucher_earned' => VoucherResource::make($this->whenLoaded('voucherEarned')),
            'voucher_used' => VoucherResource::make($this->whenLoaded('voucherUsed')),
        ];
    }
}