<?php

namespace App\Http\Requests;

use App\Models\Gender;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
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
            'full_name' => ['required', 'string'],
            'birth_date' => ['nullable', 'date'],
            'gender_id' => ['nullable', Rule::in(array_keys(Gender::NAMES))],
            'nric_passport' => ['required', 'string'],
            'phone_number' => ['nullable', 'string'],
        ];
    }
}
