<div class="container flex flex-col lg:flex-row gap-10 mt-14 relative">
    <div class="w-full lg:w-8/12 px-4 lg:px-0">
        <table class="flex flex-col lg:table w-full text-sm text-left">
            <thead>
            <tr class="*:py-8 border-b hidden lg:table-row">
                <th></th>
                <th></th>
                <th class="px-5">{{ __('Product') }}</th>
                <th class="px-5">{{ __('Price') }}</th>
                <th class="px-5 text-center">{{ __('Quantity') }}</th>
                <th class="text-right">{{ __('Subtotal') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->cartItems as $cartItem)
                <livewire:cart.components.cart-item :$cartItem :key="$cartItem->id" />
            @endforeach
            </tbody>
        </table>
    </div>

    <livewire:cart.components.cart-total :cartItems="$this->cartItems" />

    <div wire:loading class="absolute size-full bg-white/80"></div>
</div>
