<?php

namespace App\Listeners;

use App\Enums\PaymentMethod;
use App\Events\OrderPaid;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class CreatePayment
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPaid $event): void
    {

        DB::transaction(function () use ($event) {
            $order = $event->getOrder();
            $order->update(['paid_at' => now()]);

            $payment = new Payment([
                'method' => PaymentMethod::ALIPAY,
                'no' => $event->getNotify()->get('trade_no'),
                'notify_content' => $event->getNotify()->toArray(),
                'notify_mode' => $event->getNotifyMode(),
            ]);

            $payment->order()->associate($order);

            $payment->save();
        });
    }
}
