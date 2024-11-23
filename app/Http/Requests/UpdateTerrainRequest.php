<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTerrainRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'is_default' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
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
