<?php

namespace App\Livewire\Orders;

use App\Livewire\Actions\ReceiveOrder;
use App\Models\Order;
use Livewire\Component;

class OrderShow extends Component
{
    public Order $order;

    public function receive(ReceiveOrder $action): void
    {
        $this->authorize('own', $this->order);

        $action($this->order);
    }

    public function render()
    {
        $this->order->loadMissing('items.productSku.product');

        return view('livewire.orders.order-show')->title('订单详情 - 订单 '.$this->order->no);
    }
}
