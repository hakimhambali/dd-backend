<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Models\GameUser;
use App\Http\Requests\StoreGameUserVoucherRequest;

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
                // $claimedVouchers[] = $voucherData['voucher_id'];
            }
        }

        return response()->json([
            'message' => 'Player claim voucher(s) successfully',
        ], 200);
    }
}
