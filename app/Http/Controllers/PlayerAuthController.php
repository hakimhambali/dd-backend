<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests\StoreGameUserRequest;
use App\Models\GameUser;
use App\Enums\RolesEnum;

class PlayerAuthController extends Controller
{
    public function login(LoginRequest $request): JsonResponse
    {
        Log::info("PlayerAuthController-login");
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
        } else {
            $user->update([
                'last_login' => Carbon::now(),
            ]);
        }

        // Create a token for the user
        $token = $user->createToken('Player Token', ['player'])->plainTextToken;

        return response()->json(['token' => $token, 'last_login' => $user->last_login], 200);
    }

    public function register(StoreGameUserRequest $request)
    {
        $input = $request->validated();

        $username = Str::random(12);

        $userAgent = Str::lower($request->header('User-Agent'));
        $platform = 'Unknown';
    
        if (strpos($userAgent, 'huawei') !== false) {
            $platform = 'Huawei';
        } elseif (strpos($userAgent, 'android') !== false) {
            $platform = 'Android';
        } elseif (strpos($userAgent, 'iphone') !== false || strpos($userAgent, 'ipad') !== false) {
            $platform = 'iOS';
        } 

        $user = GameUser::create([
            'username' => $username,
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'country' => $input['country'] ?? 'USA',
            'platform' => $platform,
            'register_date' => Carbon::now(),
            'last_login' => Carbon::now(),
            'is_active' => 1,
        ]);

        $user->assignRole(RolesEnum::PLAYER);

        $token = $user->createToken('Player Token', ['player'])->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(): JsonResponse
    {
        Log::info("PlayerAuthController-logout");
        $user = Auth::guard('game')->user();

        Log::info('authenticatedUser: ', ['authenticatedUserData' => $user]);

        if (!$user) {
            return response()->json(['message' => 'Not authenticated.'], 401);
        }

        // Revoke the current user's token
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}