<?php

namespace App\Models;

use App\Enums\RolesEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Log;

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

    public const DEFAULT_PASSWORD_SUPERADMIN = 'passwordsuperadmin';
    public const DEFAULT_PASSWORD_ADMIN = 'passwordadmin';

    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn(): string => $this->getRoleNames()->isNotEmpty() ? RolesEnum::from($this->getRoleNames()[0])->label() : '',
        );
    }

    public function scopeNotSuperadmin(Builder $query): void
    {
        $query->whereHas('roles', fn(Builder $query): Builder => $query->whereNotIn('name', [RolesEnum::SUPERADMIN->value]));
    }

    public function scopeSearch(Builder $query, Request $request): void
    {
        Log::info('Search Method Invoked with Request User:', $request->query());
        $query

            ->when($request->query('name'), function (Builder $query, string $name) {
                $query->whereHas('profile', fn(Builder $query): Builder => $query->where('full_name', 'like', "%$name%"));
            })
            ->when($request->query('staff_no'), function (Builder $query, string $staff_no) {
                $query->whereHas('profile', fn(Builder $query): Builder => $query->where('staff_no', 'like', "%$staff_no%"));
            })
            ->when($request->query('nric_passport'), function (Builder $query, string $nric_passport) {
                $query->whereHas('profile', fn(Builder $query): Builder => $query->where('nric_passport', 'like', "%$nric_passport%"));
            })
            ->when($request->query('phone_number'), function (Builder $query, string $phone_number) {
                $query->whereHas('profile', fn(Builder $query): Builder => $query->where('phone_number', 'like', "%$phone_number%"));
            })

            ->when($request->query('role'), function (Builder $query, string $role) {
                $roleEnum = RolesEnum::tryFrom(strtolower($role));
                if ($roleEnum) {
                    $query->whereHas('roles', function (Builder $q) use ($roleEnum) {
                        $q->where('name', $roleEnum->value);
                    });
                }
            })

            ->when($request->query('email'), function (Builder $query, string $email) {
                $query->where('email', 'like', "%$email%");
            });
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function isSuperadmin(): bool
    {
        return $this->hasRole(RolesEnum::SUPERADMIN);
    }
}
