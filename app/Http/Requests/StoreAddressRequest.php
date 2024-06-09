<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAddressRequest extends FormRequest
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
            'unit_no' => ['required',],
            'address_1' => ['required'],
            'address_2' => ['required'],
            'postcode' => ['required', 'numeric'],
            'city' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
        ];
    }
}
