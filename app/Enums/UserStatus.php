<?php

namespace App\Enums;

enum UserStatus
{
    case ACTIVE;
    case PENDING;
    case DEACTIVATE;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::PENDING => 'Pending',
            self::DEACTIVATE => 'Deactivated',
        };
    }
}
