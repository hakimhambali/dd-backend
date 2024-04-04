<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    public const ID_ADMIN = 1;
    public const ID_EMPLOYEE = 2;

    public const ADMIN = 'admin';
    public const EMPLOYEE = 'employee';
}
