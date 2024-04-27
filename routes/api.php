<?php

use App\Enums\RolesEnum;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('get-csrf-cookie', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login'])->name('auth.login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('ping', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('admin')->name('admin.')->middleware('role:'.RolesEnum::ADMIN->value)->group(function () {
        Route::apiResources([
            'users' => UserController::class,
        ]);
    });
});
