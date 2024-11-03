<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string'],
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
            $rules['discount_value'] = ['required', 'numeric']; // or ['nullable'] if it should not be required when not percentage-based
        }

        return $rules;
    }
}