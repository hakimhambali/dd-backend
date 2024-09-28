<?php

namespace App\Enums;

enum RolesEnum: string
{
    case SUPERADMIN = 'superadmin';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            static::SUPERADMIN => 'Superadmin',
            static::ADMIN => 'Admin',
        };
    }
}
