<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'game_user_id' => ['required', 'integer', 'exists:game_users,id'],
            'paid_real_price' => ['nullable', 'numeric'],
            'game_price_type' => ['nullable', 'string'],
            'paid_game_price' => ['nullable', 'integer'],
            'transaction_date' => ['nullable', 'date'],
            'voucher_used_id' => ['nullable', 'integer', 'exists:vouchers,id'],
            'voucher_earned_id' => ['required', 'integer', 'exists:vouchers,id'],
            'platform' => ['required', 'string'],
        ];

        return $rules;
    }
}
