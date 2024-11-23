<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255', 'unique:profiles,full_name'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'staff_no' => ['required', 'string', 'max:255', 'unique:profiles,staff_no'],
            'nric_passport' => ['required', 'string', 'max:255', 'unique:profiles,nric_passport'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:profiles,phone_number'],
            'role' => ['required', 'string', 'in:admin,superadmin'],
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