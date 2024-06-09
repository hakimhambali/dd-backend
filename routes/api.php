<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('get-csrf-cookie', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('ping', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::apiSingleton('profile', ProfileController::class);

    Route::apiResources([
        'addresses' => AddressController::class,
    ]);
});
