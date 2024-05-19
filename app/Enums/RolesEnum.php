<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';

    public function label(): string
    {
        return match ($this) {
            static::ADMIN => 'Admin',
            static::USER => 'User',
        };
    }
}
