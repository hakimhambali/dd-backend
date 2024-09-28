<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Skin extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'skin_type',
    ];

    protected $casts = [
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
        // Search for skin_type in the Skin model
        $query->when($request->query('skin_type'), function (Builder $query, string $skin_type) {
            $query->where('skin_type', 'like', "%$skin_type%");
        });

        // Search related Product fields
        $query->when($request->query('code') || $request->query('name') || $request->query('product_type') || $request->query('is_active'), function (Builder $query) use ($request) {
            $query->whereHas('product', function (Builder $query) use ($request) {
                $query
                    ->when($request->query('code'), function (Builder $query, string $code) {
                        $query->where('code', 'like', "%$code%");
                    })
                    ->when($request->query('name'), function (Builder $query, string $name) {
                        $query->where('name', 'like', "%$name%");
                    })
                    ->when($request->query('product_type'), function (Builder $query, string $product_type) {
                        $query->where('product_type', 'like', "%$product_type%");
                    })
                    ->when($request->query('description'), function (Builder $query, string $description) {
                        $query->where('description', 'like', "%$description%");
                    })
                    ->when($request->query('is_active'), function (Builder $query, string $is_active) {
                        $query->where('is_active', filter_var($is_active, FILTER_VALIDATE_BOOLEAN));
                    });
            });
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
