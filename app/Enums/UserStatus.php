<?php

namespace App\Enums;

enum UserStatus
{
    case ACTIVE;
    case INACTIVE;
    case PENDING;
    case DELETED;

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }
}
