<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlayerAuthController;
use App\Http\Controllers\GameUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SkinController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\GameUserVoucherController;
use App\Http\Controllers\GameUserMissionController;
use App\Http\Controllers\AchievementGameUserController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\CurrencyHistoryController;
use App\Http\Controllers\TransactionHistoryController;
use App\Http\Controllers\MasterController;
use Illuminate\Support\Facades\Route;

Route::get('get-csrf-cookie', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::post('player/login', [PlayerAuthController::class, 'login']);
Route::post('player/register', [PlayerAuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('ping', [AuthController::class, 'index']);
    Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::apiResource('gameusers', GameUserController::class);
    Route::post('player-claim-reward', [GameUserController::class, 'claimReward']);
    Route::put('player/updatePassword', [GameUserController::class, 'updatePassword']);
    Route::get('player/items', [GameUserController::class, 'gameUserItems']);
    Route::get('player/skins', [GameUserController::class, 'gameUserSkins']);
    Route::get('player/vouchers', [GameUserVoucherController::class, 'gameUserVouchers']);

    Route::apiResource('products', ProductController::class)->except(['show']);
    Route::get('/products/items', [ProductController::class, 'getItems']);
    Route::get('/products/products', [ProductController::class, 'getProducts']);
    
    Route::apiResource('items', ItemController::class);
    Route::apiResource('skins', SkinController::class);

    Route::apiResource('vouchers', VoucherController::class);
    Route::post('vouchers-claim', [GameUserVoucherController::class, 'playerClaimVouchers']);

    Route::apiResource('terrains', TerrainController::class);

    Route::apiResource('missions', MissionController::class)->except(['show']);
    Route::post('assign-missions-player/{game_user_id}', [GameUserMissionController::class, 'assignMissionsPlayer']);
    // Route::post('update-missions-player', [GameUserMissionController::class, 'updateMissionsPlayer']);

    Route::apiResource('achievements', AchievementController::class);
    Route::post('update-achievements-player', [AchievementGameUserController::class, 'updateAchievementsPlayer']);

    Route::apiResource('leaderboards', LeaderboardController::class);
    Route::apiResource('currencyHistories', CurrencyHistoryController::class);
    Route::apiResource('transactionHistories', TransactionHistoryController::class);

    Route::post('sync-all-data-player', [MasterController::class, 'syncAllDataPlayer']);
    Route::post('update-race-player', [MasterController::class, 'updateRacePlayer']);
});
