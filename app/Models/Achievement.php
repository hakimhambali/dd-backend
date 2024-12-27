<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Achievement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'max_score',
        'reward_type',
        'reward_value',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
        'product_rewarded_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_score' => 'decimal:2',
        'reward_value' => 'integer',
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query
            ->when($request->query('name'), function (Builder $query, string $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->when($request->query('description'), function (Builder $query, string $description) {
                $query->where('description', 'like', "%$description%");
            })
            ->when($request->query('reward_type'), function (Builder $query, string $reward_type) {
                $query->where('reward_type', 'like', "%$reward_type%");
            })
            ->when($request->query('status'), function (Builder $query, string $status) {
                if ($status === 'deleted') {
                    $query->withTrashed()->whereNotNull('deleted_at');
                } else {
                    $query->where('is_active', filter_var($status, FILTER_VALIDATE_BOOLEAN));
                }
            });
    }

    public function productRewarded()
    {
        return $this->belongsTo(Product::class, 'product_rewarded_id');
    }

    public function game_users(): BelongsToMany
    {
        return $this->belongsToMany(GameUser::class, 'achievement_game_user');
    }
}
