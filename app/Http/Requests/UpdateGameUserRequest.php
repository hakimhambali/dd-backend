<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateGameUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email'],
            'username' => ['nullable', 'string'],
            'gold_amount' => ['nullable', 'integer'],
            'gem_amount' => ['nullable', 'integer'],
            'date_of_birth' => ['nullable', 'date'],
            'country' => ['nullable', 'string'],
            'platform' => ['nullable', 'string'],
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
