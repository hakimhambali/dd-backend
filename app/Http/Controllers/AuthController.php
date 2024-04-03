<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Response;

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
