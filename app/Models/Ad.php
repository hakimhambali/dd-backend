<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ad extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'skips',
        'real_price',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'skips' => 'integer',
        'real_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query
            ->when($request->query('status'), function (Builder $query, string $status) {
                if ($status === 'deleted') {
                    $query->withTrashed()->whereNotNull('deleted_at');
                } else {
                    $query->where('is_active', filter_var($status, FILTER_VALIDATE_BOOLEAN));
                }
            });
    }
}
