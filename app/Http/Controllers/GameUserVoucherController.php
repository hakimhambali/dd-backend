<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use App\Models\GameUser;
use App\Models\Voucher;
use App\Http\Requests\StoreGameUserVoucherRequest;
use App\Http\Resources\GameUserVoucherResource;

class GameUserVoucherController extends Controller
{
    public function playerClaimVouchers(StoreGameUserVoucherRequest $request)
    {
        $validated = $request->validated();
        $gameUser = GameUser::findOrFail($validated['game_user_id']);

        // $claimedVouchers = [];

        foreach ($validated['vouchers'] as $voucherData) {
            if (!$gameUser->vouchers()->where('voucher_id', $voucherData['voucher_id'])->exists()) {
                $gameUser->vouchers()->attach($voucherData['voucher_id']);
            }
        }

        return response()->json([
            'message' => 'Player claim voucher(s) successfully',
        ], 200);
    }

    public function gameUserVouchers() 
    {
        $authUser = Auth::guard('game')->user();
        Log::info('Authenticated User: ', ['authenticatedUserData' => $authUser]);

        if (!GameUser::find($authUser->id)) {
            return new JsonResource([
                'message' => 'Game User not found',
            ]);
        } else {
            $gameUser = GameUser::with('vouchers')->findOrFail($authUser->id);
        }

        return new GameUserVoucherResource($gameUser);
    }
}
