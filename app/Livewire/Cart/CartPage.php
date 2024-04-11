<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
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
    }

    public function clearInvalidItems(): void
    {
        $this->invalidItems->each(fn(CartItem $item) => $item->delete());

        // For reload all items
        unset($this->cartItems, $this->validItems, $this->invalidItems);
    }

    public function checkoutOrder()
    {

    }

    public function render()
    {
        return view('livewire.cart.cart-page')
            ->title(__('Cart'));
    }
}
