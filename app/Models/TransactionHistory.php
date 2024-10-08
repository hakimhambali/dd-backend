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
    }
}
