<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['nullable', 'email'],
            'password' => ['nullable', 'string', 'min:8'],
            'username' => ['nullable', 'string'],
            'gold_amount' => ['nullable', 'integer'],
            'gem_amount' => ['nullable', 'integer'],
            'date_of_birth' => ['nullable', 'date'],
            'country' => ['nullable', 'string'],
            'platform' => ['nullable', 'string'],
        ];
    }
}
