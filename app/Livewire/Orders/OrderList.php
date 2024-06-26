<?php

namespace App\Livewire\Orders;

use App\Livewire\Actions\ReceiveOrder;
use App\Models\Order;
use App\Models\User;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('我的订单')]
class OrderList extends Component
{
    use WithPagination;

    public function receive(Order $order, ReceiveOrder $action)
    {
        $this->authorize('own', $order);

        $action($order);
    }

    public function render()
    {
        /** @var User $user */
        $user = auth()->user();

        $orders = $user->orders()
            ->with('items')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.orders.order-list', [
            'orders' => $orders,
        ]);
    }
}
