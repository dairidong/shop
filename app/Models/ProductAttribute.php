<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProductAttribute
 *
 * @property int $id
 * @property string $value 商品属性值
 * @property int $product_attribute_group_id 商品属性组ID
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\ProductAttributeGroup|null $attribute_group
 *
 * @method static \Database\Factories\ProductAttributeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereProductAttributeGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductAttribute withoutTrashed()
 *
 * @mixin \Eloquent
 */
class ProductAttribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'value',
        'sort',
    ];

    protected $hidden = [
        'product_attribute_group_id',
    ];

    public function attribute_group(): BelongsTo
    {
        return $this->belongsTo(ProductAttributeGroup::class);
    }
}
