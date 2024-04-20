<?php

namespace App\Livewire\Orders;

use App\Models\CartItem;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\OrderService;
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

    public function createOrder(OrderService $service): void
    {
        $this->validate();

        DB::transaction(function () use ($service) {
            $items = $this->items->map(function (CartItem $item) {
                return [
                    'sku' => $item->product_sku,
                    'quantity' => $item->quantity,
                ];
            })->toArray();

            /** @var User $user */
            $user = auth()->user();

            $order = $service->createOrder($items, $this->currentAddress, $user);

            CartItem::query()
                ->whereIn('id', $this->items->pluck('id'))
                ->where('user_id', $user->id)
                ->delete();

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
