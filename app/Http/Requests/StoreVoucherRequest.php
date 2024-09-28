<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'min_price' => ['nullable', 'numeric'],
            'max_claim' => ['nullable', 'numeric'],
            'is_percentage_flatprice' => ['required', 'boolean'],
            'discount_value' => ['required', 'numeric'],
            'expired_time' => ['nullable', 'integer'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}
