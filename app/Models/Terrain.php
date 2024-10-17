<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

class Terrain extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'is_default',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
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
            ->when($request->query('is_default'), function (Builder $query, $is_default) {
                $query->where('is_default', filter_var($is_default, FILTER_VALIDATE_BOOLEAN));
            })
            ->when($request->query('is_active'), function (Builder $query, $is_active) {
                $query->where('is_active', filter_var($is_active, FILTER_VALIDATE_BOOLEAN));
            });
    }
}
