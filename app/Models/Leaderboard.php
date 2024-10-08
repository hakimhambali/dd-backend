<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Leaderboard extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_user_id',
        'score',
    ];

    protected $casts = [
        'score' => 'decimal:2',
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query->when($request->query('username') || $request->query('country'), function (Builder $query) use ($request) {
            $query->whereHas('game_user', function (Builder $query) use ($request) {
                $query
                    ->when($request->query('username'), function (Builder $query, string $username) {
                        $query->where('username', 'like', "%$username%");
                    })
                    ->when($request->query('country'), function (Builder $query, string $country) {
                        $query->where('country', 'like', "%$country%");
                    });
            });
        });
        $query->orderBy('id', 'asc');
    }

    public function game_user(): BelongsTo
    {
        return $this->belongsTo(GameUser::class);
    }
}
