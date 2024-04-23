<?php

namespace App\Livewire\Orders;

use App\Concerns\Livewire\HasAddresses;
use App\Models\CartItem;
use App\Models\User;
use App\Models\UserAddress;
use App\Services\OrderService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CheckoutOrderFromCart extends Component
{
    use HasAddresses;

    /**
     * @var Collection<int,CartItem>
     */
    public Collection $items;

    public function mount()
    {
        /** @var User $user */
        $user = auth()->user();

        $this->items = $user->cartItems()
            ->with('product_sku.product')->get()
            ->filter(fn(CartItem $item) => $item->checkValid() &&
                $item->quantity <= $item->product_sku->stock
            );

        if ($this->items->isEmpty()) {
            $this->redirectRoute('home', navigate: true);

            return;
        }
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

    public function createOrder(OrderService $service): void
    {
        $this->validate();
        $items = $this->items->loadMissing('product_sku.product')->map(function (CartItem $item, $index) {
            if (!$item->checkValid()) {
                $this->addError("items.{$index}", '商品不可用');
            }

            if (!$item->product_sku->on_sale || $item->product_sku->product->on_sale) {
                $this->addError("items.{$index}", '商品未上架');
            }

            if ($item->product_sku->stock < $item->quantity) {
                $this->addError("items.{$index}", '商品库存不足');
            }

            return [
                'sku' => $item->product_sku,
                'quantity' => $item->quantity,
            ];
        })->toArray();

        if ($this->getErrorBag()->any()) {
            return;
        }

        DB::transaction(function () use ($service, $items) {
            /** @var User $user */
            $user = auth()->user();

            $order = $service->createOrder($items, $this->currentAddress, $user);

            CartItem::query()
                ->whereIn('id', $this->items->pluck('id'))
                ->where('user_id', $user->id)
                ->delete();

            return $order;
        });

        // todo
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
        return view('livewire.orders.checkout-order-from-cart')
            ->title('确认订单');
    }
}
