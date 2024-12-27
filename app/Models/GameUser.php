<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
// use Illuminate\Notifications\Notifiable;

class GameUser extends Model implements AuthenticatableContract
{
    use HasApiTokens, HasRoles, HasFactory, SoftDeletes, Authenticatable;

    protected $id = 'id';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'email',
        'password',
        'username',
        'gold_amount',
        'gem_amount',
        'date_of_birth',
        'country',
        'platform',
        'register_date',
        'total_play_time',
        'is_active',
        'highest_score',
        'last_login',
    ];

    protected $casts = [
        'register_date' => 'datetime',
        'is_active' => 'boolean',
        'last_login' => 'datetime',
    ];

    protected $with = [
    ];

    protected $hidden = [
        'password',
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
            ->when($request->query('status'), function (Builder $query, string $status) {
                if ($status === 'deleted') {
                    $query->withTrashed()->whereNotNull('deleted_at');
                } else {
                    $query->where('is_active', filter_var($status, FILTER_VALIDATE_BOOLEAN));
                }
            });
    }

    public function vouchers(): BelongsToMany
    {
        return $this->belongsToMany(Voucher::class, 'game_user_voucher');
    }

    public function missions(): BelongsToMany
    {
        return $this->belongsToMany(Mission::class, 'game_user_mission');
    }

    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class, 'achievement_game_user');
    }

    public function skins(): BelongsToMany
    {
        return $this->belongsToMany(Skin::class, 'game_user_skin');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'game_user_item')->withPivot('count');
    }
}
