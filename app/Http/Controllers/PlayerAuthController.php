<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PlayerAuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        // Find the user by email
        $user = \App\Models\GameUser::where('email', $validated['email'])->first();

        // Check if user exists and verify password
        if (!$user || !password_verify($validated['password'], $user->password)) {
            return response()->json(['message' => 'Invalid email or password.'], 401);
        }

        // Log user roles and authenticated user details
        Log::info("User roles:", ['roles' => $user->getRoleNames()]);
        Log::info("Authenticated user:", ['user' => $user]);

        if (!$user->hasRole('player')) {
            return response()->json(['message' => 'Unauthorized role'], 403);
        }

        // Create a token for the user
        $token = $user->createToken('Player Token', ['player'])->plainTextToken;

        return response()->json(['token' => $token], 200);
    }
}