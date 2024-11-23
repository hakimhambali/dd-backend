<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

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
            'transaction_date' => ['nullable', 'date'],
            'voucher_used_id' => ['nullable', 'integer', 'exists:vouchers,id'],
            'voucher_earned_id' => ['required', 'integer', 'exists:vouchers,id'],
            'platform' => ['required', 'string'],
        ];

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422)
        );
    }
}
