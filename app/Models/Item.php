<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Item extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'code',
        'item_type',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query->when($request->query('item_type'), function (Builder $query, string $item_type) {
            $query->where('item_type', 'like', "%$item_type%");
        });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'item_product')->withPivot('count');
    }

    public function game_users(): BelongsToMany
    {
        return $this->belongsToMany(GameUser::class, 'game_user_item')->withPivot('count');
    }
}
