<?php

use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['role:superadmin'])->group(function () {
    Route::apiResource('users', UserController::class)->except(['show']);
});