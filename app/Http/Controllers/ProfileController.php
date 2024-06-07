<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    public function show(): JsonResource
    {
        return UserResource::make(auth()->user()->load('profile'));
    }

    public function update(UpdateProfileRequest $request): Response
    {
        $user = auth()->user()->load('profile');

        $user->profile->update($request->validated());

        return response()->noContent();
    }
}
