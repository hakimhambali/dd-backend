<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:vouchers,name'],
            'description' => ['nullable', 'string'],
            'min_price' => ['nullable', 'numeric'],
            'max_claim' => ['nullable', 'integer'],
            'is_percentage_flatprice' => ['required', 'boolean'],
            'expired_time' => ['nullable', 'integer'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_active' => ['required', 'boolean'],
        ];

        if ($this->input('is_percentage_flatprice')) {
            $rules['discount_value'] = ['required', 'numeric', 'regex:/^\d{0,2}(\.\d{1,2})?$/'];
        } else {
            $rules['discount_value'] = ['required', 'numeric'];
        }

        return $rules;
    }
}
