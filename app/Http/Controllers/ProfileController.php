<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function update(UpdateProfileRequest $request): Response
    {
        $user = auth()->user()->load('profile');

        $user->profile->update($request->validated());

        return response()->noContent();
    }
}
