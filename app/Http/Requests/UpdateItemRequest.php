<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'item_type' => ['nullable', 'string'],
        ];
    }
}
