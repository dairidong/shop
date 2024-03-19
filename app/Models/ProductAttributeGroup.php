<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProductAttributeGroup
 *
 * @property int $id
 * @property string $name 商品属性组名称
 * @property int $product_id 商品ID
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductAttribute> $attributes
 * @property-read int|null $attributes_count
 * @property-read \App\Models\Product|null $product
 *
 * @method static \Database\Factories\ProductAttributeGroupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttributeGroup withoutTrashed()
 *
 * @mixin \Eloquent
 */
class ProductAttributeGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'sort',
    ];

    protected $hidden = [
        'product_id',
    ];

    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
