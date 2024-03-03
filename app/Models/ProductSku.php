<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSku extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'bar_no',
        'attributes',
        'stock',
        'price',
        'compare_at_price',
        'cost',
        'on_sale',
        'sold_count',
    ];

    protected $casts = [
        'attributes' => 'array',
        'on_sale' => 'boolean',
    ];
}
