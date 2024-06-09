<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_no',
        'address_1',
        'address_2',
        'postcode',
        'city',
        'state',
        'country',
    ];

    public function addressable(): MorphTo
    {
        return $this->morphTo();
    }
}
