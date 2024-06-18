<?php

namespace App\Listeners;

use App\Events\OrderReviewed;
use App\Models\OrderItem;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class UpdateProductRating implements ShouldQueue
{
    public string $queue = 'update-product-rating';

    /**
     * Handle the event.
     */
    public function handle(OrderReviewed $event): void
    {
        $order = $event->getOrder();

        if (! $order->reviewed) {
            return;
        }

        $order->load('items.product');

        $order->items->each(function (OrderItem $item) {
            if (! $item->product) {
                return;
            }

            $stats = OrderItem::query()
                ->where('product_id', $item->product->id)
                ->whereNotNull('reviewed_at')
                ->first([
                    DB::raw('avg(rating) as rating'),
                    DB::raw('count(*) as review_count'),
                ]);

            $item->product?->update([
                'rating' => $stats->rating,
                'review_count' => $stats->review_count,
            ]);
        });
    }
}
