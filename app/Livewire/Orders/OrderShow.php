<?php

namespace App\Livewire\Orders;

use App\Enums\OrderShipStatus;
use App\Models\Order;
use Livewire\Component;

class OrderShow extends Component
{
    public Order $order;

    public function receive(): void
    {
        $this->authorize('own', $this->order);

        $this->order->update([
            'ship_status' => OrderShipStatus::RECEIVED,
        ]);
    }

    public function render()
    {
        $this->order->loadMissing('items.productSku.product');

        return view('livewire.orders.order-show')->title('订单详情');
    }
}
