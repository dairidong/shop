<?php

namespace App\Models;

use App\Enums\PaymentMethod;
use App\Enums\PaymentNotifyMode;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Payment
 *
 * @property int $id
 * @property int $order_id
 * @property PaymentMethod $method 支付方式
 * @property string $no 支付平台订单号
 * @property array $notify_content 支付平台查询响应
 * @property PaymentNotifyMode $notify_mode 支付平台响应方式：异步通知 callback / 主动查询 query
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $order
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNotifyContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNotifyMode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'no',
        'notify_content',
        'notify_mode',
    ];

    protected $casts = [
        'notify_content' => 'json',
        'method' => PaymentMethod::class,
        'notify_mode' => PaymentNotifyMode::class,
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
