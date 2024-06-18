<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property EloquentCollection<CartItem> $cartItems
 * @property EloquentCollection<CartItem> $validItems
 * @property EloquentCollection<CartItem> $invalidItems
 */
class CartPage extends Component
{
    public Collection $errors;

    /**
     * @var EloquentCollection<int,CartItem>
     */
    public EloquentCollection $items;

    public function mount(): void
    {
        $this->resetUserCartItems();
        $this->errors = collect([]);
    }

    /**
     * @return EloquentCollection<CartItem>
     */
    #[Computed]
    public function validItems(): EloquentCollection
    {
        return $this->items->filter(fn (CartItem $item) => $item->checkValid());
    }

    /**
     * @return Collection<CartItem>
     */
    #[Computed]
    public function invalidItems(): Collection
    {
        return $this->items->filter(fn (CartItem $item) => ! $item->checkValid());
    }

    public function remove(CartItem $cartItem): void
    {
        $this->authorize('delete', $cartItem);

        $cartItem->delete();

        $this->dispatch('cart-item-updated')->self();

        $this->resetUserCartItems();
    }

    public function clearInvalidItems(): void
    {
        $this->invalidItems->each(fn (CartItem $item) => $item->delete());

        // For reload all items
        $this->resetItems();
    }

    public function checkoutOrder(): void
    {
        if ($this->validItems->isEmpty()) {
            $this->resetItems();
            $this->addError('items', '购物车为空');
        }

        $this->validItems->each(function (CartItem $item) {
            if (! $item->checkValid()) {
                $this->addError("items.{$item->id}", '无效商品，请刷新页面');
            }

            if ($item->quantity > $item->product_sku?->stock) {
                $this->addError("items.{$item->id}", '库存不足,请修改购买数量');
            }
        });

        if ($this->getErrorBag()->isNotEmpty()) {
            $this->errors = collect($this->getErrorBag());

            return;
        }

        $this->redirectRoute('orders.create', navigate: true);
    }

    public function render()
    {
        return view('livewire.cart.cart-page')
            ->title(__('Cart'));
    }

    protected function resetUserCartItems(): void
    {
        /** @var User $user */
        $user = auth()->user();

        $this->items = $user->cartItems()->with(['product_sku', 'product'])->get();
    }

    protected function resetItems(): void
    {
        $this->resetUserCartItems();
        unset($this->validItems, $this->invalidItems);
        $this->dispatch('cart-item-updated')->self();
    }
}
