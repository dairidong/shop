<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\CarouselItem
 *
 * @property int $id
 * @property array|null $texts 相关文本
 * @property int $carousel_id
 * @property string|null $link 链接
 * @property int $sort 排序
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem whereCarouselId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem whereTexts($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarouselItem whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class CarouselItem extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'texts',
        'link',
        'sort',
    ];

    protected $casts = [
        'texts' => 'json',
    ];
}
