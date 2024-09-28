<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8'],
            'username' => ['required', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'country' => ['required', 'string'],
            'platform' => ['required', 'string'],
            'register_date' => ['required', 'date'],
        ];
    }
}
