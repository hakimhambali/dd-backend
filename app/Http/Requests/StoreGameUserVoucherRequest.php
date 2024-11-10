<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameUserVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'game_user_id' => ['required', 'integer', 'exists:game_users,id'],
            'vouchers' => ['required', 'array'],
            'vouchers.*.voucher_id' => ['required', 'integer', 'exists:vouchers,id'],
        ];
    }
}