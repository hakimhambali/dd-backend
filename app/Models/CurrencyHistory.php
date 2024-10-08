<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CurrencyHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_user_id',
        'amount',
        'currency_type',
        'description',
    ];

    protected $casts = [
        'amount' => 'integer',
    ];

    protected $with = [
    ];

    public function game_user(): BelongsTo
    {
        return $this->belongsTo(GameUser::class);
    }

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query
            ->when($request->query('currency_type'), function (Builder $query, string $currency_type) {
                $query->where('currency_type', 'like', "%$currency_type%");
            })
            ->when($request->query('description'), function (Builder $query, string $description) {
                $query->where('description', 'like', "%$description%");
            });
    }
}
