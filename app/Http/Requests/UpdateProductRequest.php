<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price_real' => ['required', 'numeric'],
            'price_game' => ['nullable', 'numeric'],
            'price_game_type' => ['nullable', 'string', 'max:255'],
            'product_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'items' => ['required', 'array'],
            'items.*.item_id' => ['required', 'integer', 'exists:items,id'],
            'items.*.count' => ['required', 'integer'],
        ];
    }
}
