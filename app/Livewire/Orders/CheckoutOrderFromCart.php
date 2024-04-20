<?php

namespace App\Livewire\Orders;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\UserAddress;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property UserAddress $currentAddress
 */
class CheckoutOrderFromCart extends Component
{
    public int $addressId;

    /**
     * @var Collection<UserAddress;
     */
    public Collection $addresses;

    /**
     * @var Collection<int,CartItem>
     */
    public Collection $items;

    public function mount()
    {
        /** @var User $user */
        $user = auth()->user();

        $this->items = $user->cartItems()
            ->with(['product_sku', 'product'])->get()
            ->filter(fn (CartItem $item) => $item->checkValid() &&
                $item->quantity <= $item->product_sku->stock
            );

        if ($this->items->isEmpty()) {
            $this->redirectRoute('home', navigate: true);

            return;
        }

        $this->addresses = $user->addresses()->latest()->get();

        $this->addressId = $this->addresses->first()->id;
    }

    #[Computed]
    public function totalAmount()
    {
        return $this->items->reduce(function ($total, CartItem $item) {
            return bcadd(
                bcmul($item->quantity, $item->product_sku->price, 2),
                $total,
                2
            );
        }, '0');
    }

    #[Computed]
    public function currentAddress()
    {
        return $this->addressId
            ? $this->addresses?->firstWhere('id', $this->addressId)
            : $this->addresses?->first();
    }

    public function createOrder(): void
    {
        $this->validate();

        DB::transaction(function () {
            $order = new Order([
                'address' => [
                    'address' => $this->currentAddress->full_address,
                    'zip' => $this->currentAddress->zip,
                    'contact_name' => $this->currentAddress->contact_name,
                    'contact_phone' => $this->currentAddress->contact_phone,
                ],
            ]);

            $order->user()->associate(auth()->user());

            $order->save();

            $amount = '0.00';

            $this->items->each(function (CartItem $item) use ($order, &$amount) {
                $orderItem = new OrderItem([
                    'quantity' => $item->quantity,
                    'price' => $item->product_sku->price,
                ]);

                $orderItem->product()->associate($item->product);
                $orderItem->productSku()->associate($item->product_sku);
                $orderItem->order()->associate($order);

                $orderItem->save();

                $item->product_sku->decreaseStock($item->quantity);

                $amount = bcadd($amount, bcmul($orderItem->quantity, $orderItem->price));
            });

            $order->update(['amount' => $amount]);

            CartItem::query()->whereIn('id', $this->items->pluck('id'))->delete();

            return $order;
        });

        $this->redirectRoute('profile', navigate: true);
    }

    public function rules(): array
    {
        /** @var User $user */
        $user = auth()->user();

        return [
            'addressId' => [
                'required',
                Rule::exists('user_addresses', 'id')->where('user_id', $user->id),
            ],
            'items' => 'required',
            'items.*.id' => [
                Rule::exists('cart_items', 'id')->where('user_id', $user->id),
            ],
        ];
    }

    public function render()
    {
        return view('livewire.orders.checkout-order-from-cart');
    }
}
