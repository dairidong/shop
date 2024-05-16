<?php

namespace App\Events;

use App\Enums\PaymentNotifyMode;
use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Yansongda\Supports\Collection;

class OrderPaid
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        protected Order $order,
        protected Collection $notify,
        protected PaymentNotifyMode $notifyMode = PaymentNotifyMode::CALLBACK
    ) {
        //
    }

    public function getOrder(): Order
    {
        return $this->order;
    }

    public function getNotify(): Collection
    {
        return $this->notify;
    }

    public function getNotifyMode(): PaymentNotifyMode
    {
        return $this->notifyMode;
    }
}
