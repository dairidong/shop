<?php

namespace App\Livewire\Cart;

use App\Models\CartItem;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CartPage extends Component
{
    #[Computed]
    public function cartItems()
    {
        return auth()->user()->cartItems->load('product_sku.product');
    }

    public function remove(CartItem $cartItem): void
    {
        if (! $cartItem) {
            return;
        }

        $this->authorize('delete', $cartItem);

        $cartItem->delete();
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
