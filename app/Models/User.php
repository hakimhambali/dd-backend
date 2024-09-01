<?php

namespace App\Models;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasRoles, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public const DEFAULT_PASSWORD = 'passw0rd*1234';

    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getRoleNames()->isNotEmpty() ? RolesEnum::from($this->getRoleNames()[0])->label() : '',
        );
    }

    public function scopeNotAdmin(Builder $query): void
    {
        $query->whereHas('roles', fn(Builder $query): Builder => $query->whereNotIn('name', [RolesEnum::ADMIN->value]));
    }

    public function scopeSearch(Builder $query, Request $request): void
    {
        $query
            ->when($request->query('name'), function (Builder $query, string $name) {
                $query->whereHas('profile', fn(Builder $query): Builder => $query->where('full_name', 'like', "%$name%"));
            })
            ->when($request->query('email'), function (Builder $query, string $email) {
                $query->where('email', 'like', "%$email%");
            });
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(RolesEnum::ADMIN);
    }
}
