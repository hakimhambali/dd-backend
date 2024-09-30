<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:game_users,email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'username' => ['required', 'string', 'unique:game_users,username', 'max:255'],
            'date_of_birth' => ['nullable', 'date'],
            'country' => ['required', 'string', 'max:255'],
            'platform' => ['required', 'string', 'max:255'],
            'register_date' => ['required', 'date'],
        ];
    }
}