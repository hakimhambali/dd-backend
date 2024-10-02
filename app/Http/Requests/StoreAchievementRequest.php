<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAchievementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:achievements,name'],
            'description' => ['nullable', 'string'],
            'max_score' => ['required', 'numeric'],
            'reward_type' => ['required', 'string', 'max:255'],
            'reward_value' => ['required', 'numeric'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}