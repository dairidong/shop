<?php

namespace App\Events;

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
    public function __construct(protected Order $order, protected Collection $result)
    {
        //
    }

    public function getOrder(): Order
    {
        return $this->order;
    }
}
