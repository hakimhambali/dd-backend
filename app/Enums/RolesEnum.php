<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';
    case PLAYER = 'player';

    public function label(): string
    {
        return match ($this) {
            static::SUPERADMIN => 'superadmin',
            static::ADMIN => 'admin',
            static::PLAYER => 'player',
        };
    }
}
