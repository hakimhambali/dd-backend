<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameUser extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email',
        'password',
        'username',
        'gem_amount',
        'gold_amount',
        'date_of_birth',
        'country',
        'platform',
        'total_play_time',
        'highest_score',
        'register_date',
        'is_active',
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
        Log::info('Search Method Invoked with Request Game User:', $request->query());
        $query
            ->when($request->query('email'), function (Builder $query, string $email) {
                $query->where('email', 'like', "%$email%");
            })
            ->when($request->query('username'), function (Builder $query, string $username) {
                $query->where('username', 'like', "%$username%");
            })
            // ->when($request->query('date_of_birth'), function (Builder $query, string $date_of_birth) {
            //     $query->whereDate('date_of_birth', $date_of_birth);
            // })
            ->when($request->query('country'), function (Builder $query, string $country) {
                $query->where('country', 'like', "%$country%");
            })
            ->when($request->query('platform'), function (Builder $query, string $platform) {
                $query->where('platform', 'like', "%$platform%");
            })
            ->when($request->query('register_date'), function (Builder $query, $register_date) {
                if ($register_date && strtotime($register_date)) {
                    $query->whereDate('register_date', $register_date);
                }
            })
            ->when($request->query('is_active'), function (Builder $query, string $is_active) {
                $query->where('is_active', filter_var($is_active, FILTER_VALIDATE_BOOLEAN));
            });
    }
}
