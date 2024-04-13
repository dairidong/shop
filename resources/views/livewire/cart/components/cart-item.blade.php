<?php

use App\Models\CartItem;
use function Livewire\Volt\mount;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\updated;

state('cartItem');
state('quantity');
state('messages')->reactive();

rules([
    'quantity' => 'required|integer|min:1'
]);

mount(function (CartItem $cartItem, $messages = []) {
    $this->cartItem = $cartItem;
    $this->quantity = $cartItem->quantity;
    $this->messages = $messages;
});

updated([
    'quantity' => function () {
        $this->validate([
            'quantity' => 'max:' . $this->cartItem->product_sku->stock,
        ]);
        $this->cartItem->update(['quantity' => $this->quantity]);
        $this->dispatch('cart-item-updated');
    }
]);

?>

<tr x-data="{
    price: {{ $cartItem->product_sku->price }},
    quantity: $wire.$entangle('quantity').live,
    subtotal: '0.00',
}"
    x-init="
        subtotal = Big(price).mul(quantity).toFixed(2);
        $watch('quantity', (value) => {
            subtotal = Big(price).mul(value).toFixed(2);
        });
    "
    :data-subtotal="subtotal"
    class="h-full grid grid-cols-[4rem_1fr] grid-rows-4 gap-x-4 lg:table-row relative text-xs lg:text-base border-b mb-2 lg:mb-0"
>
    <td class="lg:w-10 absolute lg:static right-0 top-1 lg:pt-8 lg:pb-12">
        <x-heroicon-o-x-mark
            class="size-4 hover:text-active cursor-pointer"
            wire:click="$parent.remove({{ $cartItem->id }})"
        />
    </td>
    <td class="w-16 min-w-16 py-2 row-span-full lg:pt-8 lg:pb-12">
        <a href="{{ route('products.show', [$cartItem->product]) }}" wire:navigate>
            @if($imageUrl = $cartItem->product?->getFirstMediaUrl('product-images', 'thumb'))
                <div class="size-full">
                    <img src="{{ $imageUrl }}" loading="lazy" width="400" />
                </div>
            @else
                <div class="flex items-center justify-center bg-gray-200 size-full h-20">
                    <x-heroicon-o-photo class="size-4" />
                </div>
            @endif
        </a>
    </td>
    <td class="py-1 px-0 lg:px-5 lg:pt-8 lg:pb-12 flex items-center justify-between lg:table-cell text-left border-b border-dashed">
        <div class="flex items-center lg:flex-col lg:items-start gap-x-2 lg:gap-y-6">
            <p class="font-bold text-sm lg:text-base w-[20ch] xl:w-max overflow-hidden text-ellipsis text-nowrap hover:text-active">
                <a href="{{ route('products.show', [$cartItem->product]) }}"
                   wire:navigate>{{ $cartItem->product->title }}</a>
            </p>
            <p class="text-xs lg:text-sm text-gray-400">{{ $cartItem->product_sku->name }}</p>
        </div>
        <div class="mt-6 hidden lg:block">
            <x-input-error :messages="$messages" />
        </div>
    </td>
    <td class="py-1 px-0 lg:px-5 lg:pt-8 lg:pb-12 flex items-center justify-between lg:table-cell border-b border-dashed">
        <span class="block lg:hidden">{{ __('Price') }}</span>
        <span class="text-xs" x-text="`￥${price}`"></span>
    </td>
    <td class="py-1 px-0 lg:px-5 lg:pt-8 lg:pb-12 flex items-center justify-between lg:table-cell border-b border-dashed">
        <span class="block lg:hidden">{{ __('Quantity') }}</span>
        <div class="flex lg:flex-col-reverse gap-2 items-center justify-center">
            <div class="text-xs text-gray-400">{{ __('Left stock') . ' ' . $cartItem->product_sku->stock }}</div>
            <x-cart.number-input
                min="1"
                :max="$cartItem->product_sku->stock"
                x-model.debounce.500ms="quantity"
            />
        </div>
    </td>
    <td class="py-1 lg:pt-8 lg:pb-12 flex items-center justify-between lg:table-cell text-right">
        <span class="block lg:hidden">{{ __('Subtotal') }}</span>
        <strong class="text-active text-xs font-sans font-bold"x-text="`￥${subtotal}`"></strong>
    </td>

    <td class="lg:hidden col-span-full flex justify-center">
        <x-input-error :messages="$messages" />
    </td>
</tr>
