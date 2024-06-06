<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Livewire\Component;

class ReviewOrder extends Component
{
    public Order $order;

    public function render()
    {
        return view('livewire.orders.review-order')
            ->title('评价订单 - 订单 '.$this->order->no);
    }
}
