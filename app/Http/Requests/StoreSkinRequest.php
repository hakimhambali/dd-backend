<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSkinRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:products,name'],
            'price_real' => ['required', 'numeric'],
            'price_game' => ['nullable', 'numeric'],
            'price_game_type' => ['nullable', 'string', 'max:255'],
            'skin_type' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_active' => ['required', 'boolean'],
            'parent_id' => ['nullable', 'integer', 'exists:skins,id'],
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