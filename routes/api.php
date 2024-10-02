<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameUserController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\AchievementController;
use Illuminate\Support\Facades\Route;

Route::get('get-csrf-cookie', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('ping', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::apiResource('gameusers', GameUserController::class);
    Route::apiResource('items', ItemController::class);
    Route::apiResource('skins', SkinController::class);
    Route::apiResource('vouchers', VoucherController::class);
    Route::apiResource('terrains', TerrainController::class);
    Route::apiResource('missions', MissionController::class);
    Route::apiResource('achievements', AchievementController::class);
});
