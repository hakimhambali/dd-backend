<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Voucher extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'min_price',
        'max_claim',
        'is_percentage_flatprice',
        'discount_value',
        'expired_time',
        'start_date',
        'end_date',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'expired_time' => 'integer',
        'max_claim' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'is_percentage_flatprice' => 'boolean',
        'min_price' => 'decimal:2',
        'discount_value' => 'decimal:2',
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
            ->when($request->query('is_active'), function (Builder $query, $is_active) {
                $query->where('is_active', filter_var($is_active, FILTER_VALIDATE_BOOLEAN));
            })
            ->when($request->query('is_percentage_flatprice'), function (Builder $query, $is_percentage_flatprice) {
                $query->where('is_percentage_flatprice', filter_var($is_percentage_flatprice, FILTER_VALIDATE_BOOLEAN));
            });
    }

    public function game_users(): BelongsToMany
    {
        return $this->belongsToMany(GameUser::class, 'game_user_voucher');
    }
}
