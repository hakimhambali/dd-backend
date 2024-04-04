<?php

namespace App\Enums;

enum RolesEnum: string
{
    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';

    public function label(): string
    {
        return match ($this) {
            static::ADMIN => 'Admin',
            static::EMPLOYEE => 'Employee',
        };
    }
}
