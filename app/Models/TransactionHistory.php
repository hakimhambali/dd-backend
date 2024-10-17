<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TransactionHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'game_user_id',
        'buy_price',
        'transaction_date',
        'voucher_used_id',
        'voucher_earned_id',
        'platform',
    ];

    protected $casts = [
        'buy_price' => 'decimal:2',
        'transaction_date' => 'datetime',
    ];

    protected $with = [
    ];

    public function game_user(): BelongsTo
    {
        return $this->belongsTo(GameUser::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    
    public function voucherUsed(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'voucher_used_id');
    }

    public function voucherEarned(): BelongsTo
    {
        return $this->belongsTo(Voucher::class, 'voucher_earned_id');
    }

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query
            ->when($request->query('platform'), function (Builder $query, string $platform) {
                $query->where('platform', 'like', "%$platform%");
            });

        $query->when($request->query('username'), function (Builder $query) use ($request) {
            $query->whereHas('game_user', function (Builder $query) use ($request) {
                $query
                    ->when($request->query('username'), function (Builder $query, string $username) {
                        $query->where('username', 'like', "%$username%");
                    });
            });
        });

        $query->when($request->query('product_code') || $request->query('product_name') || $request->query('product_type'), function (Builder $query) use ($request) {
            $query->whereHas('product', function (Builder $query) use ($request) {
                $query
                    ->when($request->query('product_code'), function (Builder $query, string $product_code) {
                        $query->where('code', 'like', "%$product_code%");
                    })
                    ->when($request->query('product_name'), function (Builder $query, string $product_name) {
                        $query->where('name', 'like', "%$product_name%");
                    })
                    ->when($request->query('product_type'), function (Builder $query, string $product_type) {
                        $query->where('product_type', 'like', "%$product_type%");
                    });
            });
        });

        $query->when($request->query('voucher_used_name') || $request->query('voucher_used_is_percentage_flatprice'), function (Builder $query) use ($request) {
            $query->whereHas('voucherUsed', function (Builder $query) use ($request) {
                $query
                    ->when($request->query('voucher_used_name'), function (Builder $query, string $voucher_used_name) {
                        $query->where('name', 'like', "%$voucher_used_name%");
                    })
                    ->when($request->query('voucher_used_is_percentage_flatprice'), function (Builder $query, $voucher_used_is_percentage_flatprice) {
                        $query->where('is_percentage_flatprice', filter_var($voucher_used_is_percentage_flatprice, FILTER_VALIDATE_BOOLEAN));
                    });
            });
        });

        $query->when($request->query('voucher_earned_name') || $request->query('voucher_earned_is_percentage_flatprice'), function (Builder $query) use ($request) {
            $query->whereHas('voucherEarned', function (Builder $query) use ($request) {
                $query
                    ->when($request->query('voucher_earned_name'), function (Builder $query, string $voucher_earned_name) {
                        $query->where('name', 'like', "%$voucher_earned_name%");
                    })
                    ->when($request->query('voucher_earned_is_percentage_flatprice'), function (Builder $query, $voucher_earned_is_percentage_flatprice) {
                        $query->where('is_percentage_flatprice', filter_var($voucher_earned_is_percentage_flatprice, FILTER_VALIDATE_BOOLEAN));
                    });
            });
        });
    }
}
