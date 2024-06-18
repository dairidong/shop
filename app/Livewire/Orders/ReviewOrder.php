<?php

namespace App\Livewire\Orders;

use App\Events\OrderReviewed;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ReviewOrder extends Component
{
    public Order $order;

    #[Validate]
    public array $reviews = [];

    public function boot(): void
    {
        $this->order->load('items');
    }

    public function mount()
    {
        $this->order->loadMissing('items');

        foreach ($this->order->items as $item) {
            $this->reviews[$item->id] = [
                'item_id' => $item->id,
                'rating' => 0,
                'review' => '',
            ];
        }
    }

    public function submitReviews(): void
    {
        $this->validate();

        DB::transaction(function () {
            $now = now();

            $this->order->items->each(function (OrderItem $item) use ($now) {
                $item->update([
                    'rating' => $this->reviews[$item->id]['rating'],
                    'review' => $this->reviews[$item->id]['review'] === '' ? null : $this->reviews[$item->id]['review'],
                    'reviewed_at' => $now,
                ]);
            });

            $this->order->reviewed = true;
            $this->order->save();
        });

        event(new OrderReviewed($this->order));

        $this->redirectRoute('orders.show', [$this->order]);
    }

    public function render()
    {
        return view('livewire.orders.review-order')
            ->title('评价订单 - 订单 '.$this->order->no);
    }

    public function rules(): array
    {
        return [
            'reviews' => 'array|required',
            'reviews.*' => 'required|array:item_id,rating,review',
            'reviews.*.item_id' => ['integer', 'min:1', Rule::in($this->order->items->pluck('id'))],
            'reviews.*.rating' => ['required', 'integer', 'between:1,5'],
            'reviews.*.review' => ['string', 'max:500'],
        ];
    }

    public function messages()
    {
        return [
            'reviews.*.rating.required' => '请选择评分',
            'reviews.*.rating.integer' => '请重新选择评分',
            'reviews.*.rating.between' => '请重新选择评分',
            'reviews.*.review.string' => '评论格式异常',
            'reviews.*.review.max' => '评论内容不能超过500个字符',
        ];
    }
}
