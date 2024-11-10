<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreGameUserRewardRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'game_user_id' => ['required', 'integer', 'exists:game_users,id'],

            'game_user' => ['nullable', 'array'],
            'game_user.*.gold_amount' => ['nullable', 'integer'],
            'game_user.*.gem_amount' => ['nullable', 'integer'],
            
            'skins' => ['nullable', 'array'],
            'skins.*.skin_id' => ['required', 'integer', 'exists:skins,id'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error' => 'Request data is incorrect',
            ], 404)
        );
    }
}
