<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\ProductSku
 *
 * @property int $id
 * @property string $name 规格名称
 * @property string $bar_no sku 编号
 * @property array $attributes 商品属性
 * @property int $stock 库存
 * @property string $price 价格
 * @property string $compare_at_price 商品比较原价
 * @property string $cost 成本价
 * @property bool $on_sale 是否上架
 * @property int $sold_count 销量
 * @property int $product_id 商品 ID
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @method static \Database\Factories\ProductSkuFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereAttributes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereBarNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereCompareAtPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereOnSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereSoldCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductSku withoutTrashed()
 *
 * @property-read \App\Models\Product|null $product
 * @property-read mixed $valid
 *
 * @mixin \Eloquent
 */
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

    protected $hidden = [
        'product',
        'product_id',
        'deleted_at',
    ];

    protected static function booted(): void
    {
        static::saving(function (ProductSku $sku) {
            if ($sku->isDirty('attributes') && ! $sku->isDirty('name')) {
                $sku->name = collect($sku->getAttribute('attributes'))->pluck('value')->join('+');
            }
        });

        static::saved(function (ProductSku $sku) {
            $product = $sku->product->load('skus');
            $minPrice = $product->skus->where('price', '>', 0)->min('price');
            $minComparePrice = $product->skus->where('compare_at_price', '>', 0)->min('compare_at_price');

            $product->update([
                'price' => $minPrice,
                'compare_at_price' => $minComparePrice,
            ]);
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function valid(): Attribute
    {
        return Attribute::make(
            get: function () {
                $groupIds = $this->product->loadMissing([
                    'attribute_groups' => function (Builder $query) {
                        $query->whereHas('attributes');
                    },
                ])->attribute_groups->pluck('id')
                    ->sort()->values()->all();

                $attributes = collect($this->getAttribute('attributes'))
                    ->pluck('product_attribute_group_id')
                    ->sort()->values()->all();

                return $groupIds === $attributes;
            }
        );
    }

    public function decreaseStock(int $quantity): int
    {
        if ($quantity < 0) {
            throw new \Exception('库存扣减数量异常');
        }

        return static::query()
            ->where('id', $this->id)
            ->where('stock', '>=', $quantity)
            ->decrement('stock', $quantity);
    }
}
