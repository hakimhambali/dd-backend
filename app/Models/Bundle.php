<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Bundle extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'price_real',
        'price_game',
        'price_game_type',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price_real' => 'decimal:2',
        'price_game' => 'integer',
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query
            ->when($request->query('code'), function (Builder $query, string $code) {
                $query->where('code', 'like', "%$code%");
            })
            ->when($request->query('name'), function (Builder $query, string $name) {
                $query->where('name', 'like', "%$name%");
            })
            ->when($request->query('description'), function (Builder $query, string $description) {
                $query->where('description', 'like', "%$description%");
            });
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'bundle_product');
    }
}
