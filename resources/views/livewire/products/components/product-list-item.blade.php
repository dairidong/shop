<?php

use App\Models\Product;
use function Livewire\Volt\{mount, state};

state('product');

mount(function (Product $product) {
    $this->product = $product;
});

?>

<div class="flex flex-col">
    <div class="relative overflow-hidden"
         x-data="{actionsShown: false}"
         x-on:mouseenter="actionsShown = true"
         x-on:mouseleave="actionsShown = false"
    >
        <a href="{{ route('product.show', $product) }}" class="block w-full h-[533px]" wire:navigate>
            <div x-data="{shown: false}"
                 x-intersect.once="shown = true"
                 class="flex items-center justify-center relative size-full bg-gray-200"
            >
                <x-heroicon-o-photo class="size-16"/>

                <div x-show="shown" class="absolute bg-black size-full flex items-center">
                    <x-lazy-image :src="$product->getFirstMediaUrl('product-images')"/>
                </div>
            </div>
        </a>

        {{-- actions --}}
        <div x-show="actionsShown"
             x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="-translate-y-full"
             class="absolute top-0 right-0 bg-white"
        >
            <button class="flex items-center justify-center size-10 hover:text-white hover:bg-active">
                <x-heroicon-o-shopping-cart class="size-4"/>
            </button>
            <button class="flex items-center justify-center size-10 hover:text-white hover:bg-active">
                <x-heroicon-o-heart class="size-4"/>
            </button>
        </div>
    </div>

    <div class="flex flex-col justify-center items-center gap-1 px-4 py-6">
        <div>
            <a href="{{ route('product.show', $product) }}" class="font-bold hover:text-active" wire:navigate>
                {{ $product->title }}
            </a>
        </div>
        <div>￥{{ $product->price }}</div>
    </div>

</div>
