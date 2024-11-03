<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'price_real' => ['required', 'numeric'],
            'price_game' => ['nullable', 'numeric'],
            'price_game_type' => ['nullable', 'string', 'max:255'],
            'skin_type' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'parent_id' => ['nullable', 'integer', 'exists:skins,id'],
        ];
    }
}
