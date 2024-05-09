<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;

class OrderShow extends Component
{
    public Order $order;

    public function render()
    {
        $this->order->loadMissing('items.productSku.product');
        return view('livewire.orders.order-show')->title('订单详情');
    }
}
