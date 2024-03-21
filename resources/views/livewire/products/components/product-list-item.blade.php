<?php

use App\Models\Product;
use function Livewire\Volt\{computed, mount, state};

state('product');

mount(function (Product $product) {
    $this->product = $product;
});

$image = computed(fn() => $this->product->getFirstMediaUrl('product-images'));

?>

<div class="flex flex-col">
    <div class="relative overflow-hidden"
         x-data="{ actionsShown: false }"
         x-intersect.once="imageShow = true"
         x-on:mouseenter="actionsShown = true"
         x-on:mouseleave="actionsShown = false"
    >
        <a href="{{ route('product.show', $product) }}" class="block w-full h-[533px] sm:h-[266px] md:h-[360px] lg:h-[420px] xl:h-[533px] relative" wire:navigate>
            <div class="flex items-center justify-center size-full bg-gray-200">
                <x-heroicon-o-photo class="size-16" />
            </div>

            @if($this->image)
                <div class="top-0 absolute bg-black size-full flex items-center">
                    <x-lazy-image :src="$this->image" />
                </div>
            @endif
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
                <x-heroicon-o-shopping-cart class="size-4" />
            </button>
            <button class="flex items-center justify-center size-10 hover:text-white hover:bg-active">
                <x-heroicon-o-heart class="size-4" />
            </button>
        </div>
    </div>

    <div class="flex flex-col justify-center items-center gap-1 px-4 py-6">
        <a href="{{ route('product.show', $product) }}" class="block font-bold text-center hover:text-active"
           wire:navigate>
            {{ $product->title }}
        </a>
        <div class="text-sm lg:text-base">￥{{ $product->price }}</div>
    </div>

</div>
