<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Religion extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public const ID_ISLAM = 1;

    public const ID_CHRISTIANITY = 2;

    public const ID_HINDUISM = 3;

    public const ID_BUDDHISM = 4;

    public const ID_JAINISM = 5;

    public const ID_SIKHISM = 6;

    public const ID_FOLK_RELIGIONS = 7;

    public const ID_NO_RELIGION = 8;

    public const ID_OTHERS = 9;

    public const NAMES = [
        self::ID_ISLAM => 'Islam',
        self::ID_CHRISTIANITY => 'Christianity',
        self::ID_HINDUISM => 'Hinduism',
        self::ID_BUDDHISM => 'Buddhism',
        self::ID_JAINISM => 'Jainism',
        self::ID_SIKHISM => 'Sikhism',
        self::ID_FOLK_RELIGIONS => 'Folk Religions',
        self::ID_NO_RELIGION => 'No Religion',
        self::ID_OTHERS => 'Others',
    ];

    /**
     * Retrieve the users associated with this religion.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
