<?php

namespace App\Services;

use App\Jobs\CloseOrder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductSku;
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
            /** @var ProductSku $sku */
            $sku = $item['sku']->loadMissing('product');

            $orderItem = new OrderItem([
                'quantity' => $item['quantity'],
                'price' => $sku->price,
                'sku_snapshot' => [
                    ...$sku->only(['id', 'name', 'bar_no', 'attributes']),
                    'product' => [
                        ...$sku->product->only(['id', 'title', 'long_title', 'product_no']),
                        'image' => $sku->product->getFirstMediaUrl('product-images'),
                    ],
                ],
            ]);

            $orderItem->productSku()->associate($sku);
            $orderItem->product()->associate($sku->product);
            $orderItem->order()->associate($order);
            $orderItem->user()->associate($user);

            $orderItem->save();

            $sku->decreaseStock($item['quantity']);

            $amount = bcadd($amount, bcmul($orderItem->quantity, $orderItem->price));
        }

        $order->update(['amount' => $amount]);

        dispatch(new CloseOrder($order))->delay($order->paid_expired_at)->afterCommit()->onQueue('close-order');

        return $order;
    }
}
