<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property Collection<CartItem> $cartItems
 * @property Collection<CartItem> $validItems
 * @property Collection<CartItem> $invalidItems
 */
class CartPage extends Component
{
    /**
     * @return Collection<CartItem>
     */
    #[Computed]
    public function cartItems(): Collection
    {
        /** @var User $user */
        $user = auth()->user();

        return $user->cartItems()->with(['product_sku', 'product'])->get();
    }

    /**
     * @return Collection<CartItem>
     */
    #[Computed]
    public function validItems(): Collection
    {
        return $this->cartItems->filter(fn(CartItem $item) => $item->checkValid());
    }

    /**
     * @return Collection<CartItem>
     */
    #[Computed]
    public function invalidItems(): Collection
    {
        return $this->cartItems->filter(fn(CartItem $item) => !$item->checkValid());
    }

    public function remove(CartItem $cartItem): void
    {
        if (!$cartItem) {
            return;
        }

        $this->authorize('delete', $cartItem);

        $cartItem->delete();

        $this->dispatch('cart-item-updated')->self();
    }

    public function clearInvalidItems(): void
    {
        $this->invalidItems->each(fn(CartItem $item) => $item->delete());

        // For reload all items
        $this->resetItems();
    }

    public function checkoutOrder(): void
    {
        if ($this->validItems->isEmpty()) {
            $this->resetItems();
            throw ValidationException::withMessages([
                'items' => '购物车为空',
            ]);
        }

        $this->validItems->each(function (CartItem $item) {
            if (!$item->checkValid()) {
                $this->addError("items.{$item->id}", '无效商品，请刷新页面');
            }

            if ($item->quantity > $item->product_sku->stock) {
                $this->addError("items.{$item->id}", '库存不足,请修改购买数量');
            }
        });
    }

    public function render()
    {
        return view('livewire.cart.cart-page')
            ->title(__('Cart'));
    }

    protected function resetItems():void
    {
        unset($this->cartItems, $this->validItems, $this->invalidItems);
        $this->dispatch('cart-item-updated')->self();
    }
}
