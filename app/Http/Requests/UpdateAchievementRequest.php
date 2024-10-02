<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
        ];
    }
}
