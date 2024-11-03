<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:missions,name'],
            'description' => ['nullable', 'string'],
            'max_score' => ['required', 'numeric'],
            'reward_type' => ['nullable', 'string', 'max:255', 'required_without:product_rewarded_id'],
            'reward_value' => ['nullable', 'numeric', 'required_without:product_rewarded_id'],
            'is_active' => ['required', 'boolean'],
            'product_rewarded_id' => ['nullable', 'exists:products,id', 'required_without:reward_type,reward_value'],
        ];
    }
}