<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Order
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderItem> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\OrderFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 *
 * @property int $id
 * @property string $no 订单号
 * @property int $user_id
 * @property array $address 收货地址
 * @property string $amount 订单总计
 * @property string $remark 备注
 * @property \Illuminate\Support\Carbon|null $paid_at 支付时间
 * @property int $closed 是否关闭
 * @property int $reviewed 是否已评论
 * @property string $ship_status 配送状态
 * @property array|null $ship_data 物流信息
 * @property array|null $extra 额外信息
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereClosed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShipStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'no',
        'address',
        'amount',
        'remark',
        'paid_at',
        'closed',
        'reviewed',
        'ship_status',
        'ship_data',
        'extra',
    ];

    protected $casts = [
        'address' => 'json',
        'ship_data' => 'json',
        'extra' => 'json',
        'paid_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function (Order $order) {
            if (!$order->no) {
                $order->no = Order::generateAvailableNo();
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function generateAvailableNo(): string
    {
        $prefix = date('YmdHis');
        do {
            $no = $prefix.str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (static::query()->where('no', $no)->exists());

        return $no;
    }
}