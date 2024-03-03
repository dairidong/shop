<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Product
 *
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 *
 * @mixin \Eloquent
 */
class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'long_title',
        'product_no',
        'images',
        'on_sale',
        'rating',
        'sold_count',
        'review_count',
        'price',
        'compare_at_price',
        'extra',
    ];

    protected $casts = [
        'images' => 'array',
        'on_sale' => 'boolean',
        'extra' => 'json',
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function attribute_groups(): HasMany
    {
        return $this->hasMany(ProductAttributeGroup::class);
    }

    public function skus(): HasMany
    {
        return $this->hasMany(ProductSku::class);
    }
}
