<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::get('/users/me', [UserController::class, 'me']);
