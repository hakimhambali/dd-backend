<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    public const ID_MALE = 1;
    public const ID_FEMALE = 2;

    public const NAMES = [
        self::ID_MALE => 'Male',
        self::ID_FEMALE => 'Female',
    ];
}
