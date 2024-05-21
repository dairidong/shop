<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Carousel
 *
 * @property int $id
 * @property string $name 轮播图集合名称
 * @property string $key 集合标识
 * @property array $text_columns 轮播图相关文本字段
 * @property bool $has_link 是否拥有链接
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CarouselItem> $items
 * @property-read int|null $items_count
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereHasLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereTextColumns($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Carousel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Carousel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'key',
        'text_columns',
        'has_link',
    ];

    protected $casts = [
        'text_columns' => 'array',
        'has_link' => 'boolean',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(CarouselItem::class);
    }
}
