<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateMasterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'game_user_id' => ['required', 'integer', 'exists:game_users,id'],
            
            // Game User data validation
            'game_user' => ['nullable', 'array'],
            'game_user.*.email' => ['nullable', 'email'],
            'game_user.*.username' => ['nullable', 'string'],
            'game_user.*.gold_amount' => ['nullable', 'integer'],
            'game_user.*.gem_amount' => ['nullable', 'integer'],
            'game_user.*.date_of_birth' => ['nullable', 'date'],
            'game_user.*.country' => ['nullable', 'string'],
            'game_user.*.platform' => ['nullable', 'string'],
            'game_user.*.total_play_time' => ['nullable', 'numeric'],
            'game_user.*.is_active' => ['nullable', 'boolean'],
            'game_user.*.highest_score' => ['nullable', 'numeric'],

            // Missions validation
            'missions' => ['nullable', 'array'],
            'missions.*.mission_id' => ['required_with:missions', 'integer', 'exists:missions,id'],
            'missions.*.is_completed' => ['required_with:missions', 'boolean'],
            'missions.*.score' => ['required_with:missions', 'numeric', 'min:0'],

            // Achievements validation
            'achievements' => ['nullable', 'array'],
            'achievements.*.achievement_id' => ['required_with:achievements', 'integer', 'exists:achievements,id'],
            'achievements.*.is_completed' => ['required_with:achievements', 'boolean'],
            'achievements.*.score' => ['required_with:achievements', 'numeric', 'min:0'],

            // Vouchers validation
            'vouchers' => ['nullable', 'array'],
            'vouchers.*.voucher_id' => ['required_with:vouchers', 'integer', 'exists:vouchers,id'],

            // Skins validation
            'skins' => ['nullable', 'array'],
            'skins.*.skin_id' => ['required', 'integer', 'exists:skins,id'],
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