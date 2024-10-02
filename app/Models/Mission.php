<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Mission extends Model
{
    use HasFactory;

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
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'max_score' => 'decimal:2',
        'reward_value' => 'decimal:2',
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
            ->when($request->query('reward_value'), function (Builder $query, string $reward_value) {
                $query->where('reward_value', 'like', "%$reward_value%");
            });
    }
}
