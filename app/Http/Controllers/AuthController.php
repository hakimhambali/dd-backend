<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function index(): Response
    {
        return response()->noContent();
    }

    public function login(LoginRequest $request): Response
    {
        $validated = $request->validated();

        abort_if(!auth('web')->attempt($validated), Response::HTTP_UNAUTHORIZED, 'Invalid email or password.');

        // $user = auth('web')->user();
        // Log::info("Authenticated user:", ['user' => $user]);
        // $roles = $user->getRoleNames(); 
        // Log::info("User roles:", ['roles' => $roles]);

        $request->session()->regenerate();

        return response()->noContent();
    }

    public function logout(): Response
    {
        auth('web')->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return response()->noContent();
    }
}
