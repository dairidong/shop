<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserAddress;

class OrderService
{
    public function createOrder(array $items, UserAddress $address, User $user): Order
    {
        $order = new Order([
            'address' => [
                'address' => $address->full_address,
                'zip' => $address->zip,
                'contact_name' => $address->contact_name,
                'contact_phone' => $address->contact_phone,
            ],
        ]);

        $order->user()->associate($user);

        $order->save();

        $amount = '0.00';

        foreach ($items as $item) {
            $orderItem = new OrderItem([
                'quantity' => $item['quantity'],
                'price' => $item['sku']->price,
            ]);

            $orderItem->productSku()->associate($item['sku']);
            $orderItem->product()->associate($item['sku']->product);
            $orderItem->order()->associate($order);

            $orderItem->save();

            $item['sku']->decreaseStock($item['quantity']);

            $amount = bcadd($amount, bcmul($orderItem->quantity, $orderItem->price));
        }

        $order->update(['amount' => $amount]);

        return $order;
    }
}
