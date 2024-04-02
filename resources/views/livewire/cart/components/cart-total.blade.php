<?php

use App\Models\CartItem;
use function Livewire\Volt\computed;
use function Livewire\Volt\on;
use function Livewire\Volt\state;

state('cartItems');

$total = computed(function () {
    return $this->cartItems
        ->map(fn(CartItem $cart) => bcmul($cart->product_sku->price, $cart->quantity, 2))
        ->reduce(fn($prevTotal, $sub) => bcadd($prevTotal, $sub, 2), 0);
});
?>

<div class="w-full lg:w-4/12" @cart-item-updated.window="$wire.$refresh()">
    <div class="pt-2 pb-8 px-5 border-2">
        <h2 class="my-4 text-2xl font-bold">{{ __('Cart Totals') }}</h2>

        <section class="flex justify-between border-b py-3">
            <span class="font-bold">{{ __('Subtotal') }}</span>
            <span class="text-active">{{ $this->total }}</span>
        </section>

        <section class="flex justify-between py-3">
            <span class="font-bold">{{ __('Total') }}</span>
            <span class="font-bold text-active">{{ $this->total }}</span>
        </section>

        <div class="mt-5">
            <x-primary-button :value="__('Checkout Order')" class="w-full text-sm font-bold h-14" @click="$parent.checkoutOrder" />
        </div>
    </div>
</div>
