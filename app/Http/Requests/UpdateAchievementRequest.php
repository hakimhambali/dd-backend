<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAchievementRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'max_score' => ['nullable', 'numeric'],
            'reward_type' => ['nullable', 'string', 'max:255'],
            'reward_value' => ['nullable', 'numeric'],
            'is_active' => ['required', 'boolean'],
            'product_rewarded_id' => ['nullable', 'exists:products,id'],
        ];
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
