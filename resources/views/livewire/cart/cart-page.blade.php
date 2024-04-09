<div
    class="container flex flex-col lg:flex-row gap-10 mt-14 relative"
    x-data="{
        cartTotal: '0.00',
        calculateTotal() {
            const elements = $el.querySelectorAll('[data-subtotal]');
            this.cartTotal = Array.prototype.reduce.call(elements, (prev, el) => {
                return Big(prev).add(el.dataset['subtotal']).toFixed(2);
            }, '0.00');
        }
    }"
    @cart-item-updated="calculateTotal()"
    x-init="$nextTick(() => calculateTotal())"
>
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

    <div class="w-full lg:w-4/12">
        <div class="pt-2 pb-8 px-5 border-2">
            <h2 class="my-4 text-2xl font-bold">{{ __('Cart Totals') }}</h2>

            <section class="flex justify-between border-b py-3">
                <span class="font-bold">{{ __('Subtotal') }}</span>
                <span class="text-active" x-text="`￥${cartTotal}`"></span>
            </section>

            <section class="flex justify-between py-3">
                <span class="font-bold">{{ __('Total') }}</span>
                <span class="font-bold text-active" x-text="`￥${cartTotal}`"></span>
            </section>

            <div class="mt-5">
                <x-primary-button value="确认订单" class="w-full text-sm font-bold h-14" wire:click.prevent="checkoutOrder" />
            </div>
        </div>
    </div>

    <div wire:loading class="absolute size-full bg-white/80"></div>
</div>
