<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'staff_no' => ['required', 'string', 'max:255', 'unique:profiles,staff_no'],
            'nric_passport' => ['required', 'string', 'max:255', 'unique:profiles,nric_passport'],
            'phone_number' => ['required', 'string', 'max:255', 'unique:profiles,phone_number'],
            'role' => ['required', 'string', 'in:admin,superadmin'],
        ];
    }
}
