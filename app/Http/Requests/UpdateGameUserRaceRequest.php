<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateGameUserRaceRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'game_user_id' => ['required', 'integer', 'exists:game_users,id'],
            
            'missions' => ['required', 'array'],
            'missions.*.mission_id' => ['required', 'integer', 'exists:missions,id'],
            'missions.*.is_completed' => ['required', 'boolean'],
            'missions.*.score' => ['required', 'numeric', 'min:0'],

            'achievements' => ['required', 'array'],
            'achievements.*.achievement_id' => ['required', 'integer', 'exists:achievements,id'],
            'achievements.*.is_completed' => ['required', 'boolean'],
            'achievements.*.score' => ['required', 'numeric', 'min:0'],

            'game_user' => ['nullable', 'array'],
            'game_user.*.total_play_time' => ['nullable', 'numeric'],
            'game_user.*.highest_score' => ['nullable', 'numeric'],
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
