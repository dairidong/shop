<?php

namespace App\Livewire\Actions;

use App\Enums\OrderShipStatus;
use App\Models\Order;

class ReceiveOrder
{
    public function __invoke(Order $order): void
    {
        $order->update([
            'ship_status' => OrderShipStatus::RECEIVED,
        ]);
    }
}
