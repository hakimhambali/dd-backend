<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class Offer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'discount_percent',
        'price_real_before_discount',
        'price_real_after_discount',
        'product_id',
    ];

    protected $casts = [
        'discount_percent' => 'integer',
        'price_real_before_discount' => 'decimal:2',
        'price_real_after_discount' => 'decimal:2',
    ];

    protected $with = [
    ];

    public function scopeSearch(Builder $query, Request $request): void
    {
    }

    public function productOffered()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
