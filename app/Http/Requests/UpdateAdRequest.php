<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateAdRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'skips' => ['required', 'integer'],
            // 'skips' => [
            //     'required',
            //     'integer',
            //     Rule::unique('ads', 'skips')->ignore($this->route('ad')->id),
            // ],
            'real_price' => ['required', 'numeric'],
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
