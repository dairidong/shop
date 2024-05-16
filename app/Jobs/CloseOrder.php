<?php

namespace App\Jobs;

use App\Enums\AlipayNotifyStatus;
use App\Enums\PaymentNotifyMode;
use App\Events\OrderPaid;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Yansongda\LaravelPay\Facades\Pay;

class CloseOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Order $order)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if ($this->order->paid_at) {
            return;
        }

        $result = Pay::alipay()->query(['out_trade_no' => $this->order->no]);

        if (AlipayNotifyStatus::success($result->get('trade_status'))) {
            event(new OrderPaid($this->order, $result,PaymentNotifyMode::QUERY));

            return;
        }

        $this->order->load('items.productSku');

        DB::transaction(function () {
            $this->order->update(['closed' => true]);

            $this->order->items->each(function (OrderItem $item) {
                $item->productSku?->increaseStock($item->quantity);
            });
        });
    }
}
