<div
    class="container flex flex-col lg:flex-row gap-10 mt-14 relative"
    x-data="{
        cartTotal: '0.00',
        calculateTotal() {
            const elements = this.$el.querySelectorAll('[data-subtotal]');
            this.cartTotal = Array.prototype.reduce.call(elements, (prev, el) => {
                return Big(prev).add(el.dataset['subtotal']).toFixed(2);
            }, '0.00');
        }
    }"
    @cart-item-updated="$nextTick(() => calculateTotal())"
    x-init="$nextTick(() => calculateTotal())"
>
    <div class="w-full lg:w-8/12 px-4 lg:px-0">
        <table class="flex flex-col lg:table w-full text-sm text-left mb-12">
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
                @foreach($this->validItems as $cartItem)
                    <livewire:cart.components.cart-item
                        :$cartItem
                        :key="$cartItem->id"
                    />
                @endforeach
            </tbody>
        </table>

        @if($this->invalidItems->isNotEmpty())
            <table class="flex flex-col lg:table w-full text-sm text-left">
                <thead>
                    <tr class="*:py-8 border-b table-row">
                        <th></th>
                        <th class="text-gray-600">无效商品</th>
                        <th class="px-5"></th>
                        <th class="px-5"></th>
                        <th class="px-5 text-center"></th>
                        <th class="text-right">
                            <a class="hover:text-active cursor-pointer" wire:click.prevent="clearInvalidItems">清除无效商品</a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($this->invalidItems as $cartItem)
                        <tr class="h-full grid grid-cols-[4rem_1fr] grid-rows-4 gap-x-4 lg:table-row relative text-xs lg:text-base border-b mb-2 lg:mb-0">
                            <td class="lg:w-10 absolute lg:static right-0 top-1 lg:pt-8 lg:pb-12">
                                <x-heroicon-o-x-mark
                                    class="size-4 hover:text-active cursor-pointer"
                                    wire:click="remove({{ $cartItem->id }})"
                                />
                            </td>
                            <td class="w-16 min-w-16 py-2 row-span-full lg:pt-8 lg:pb-12">
                                @if($imageUrl = $cartItem->product?->getFirstMediaUrl('product-images', 'thumb'))
                                    <div class="size-full">
                                        <img src="{{ $imageUrl }}" loading="lazy" width="400" />
                                    </div>
                                @else
                                    <div class="flex items-center justify-center bg-gray-200 size-full h-20">
                                        <x-heroicon-o-photo class="size-4" />
                                    </div>
                                @endif
                            </td>
                            <td class="py-1 px-0 lg:px-5 lg:pt-8 lg:pb-12 flex items-center justify-between lg:table-cell text-left border-b border-dashed">
                                <div class="flex items-center lg:flex-col lg:items-start gap-x-2 lg:gap-y-6">
                                    <p class="font-bold text-sm lg:text-base w-[20ch] xl:w-max overflow-hidden text-ellipsis text-nowrap text-gray-400 line-through">
                                        {{ $cartItem->product?->title }}
                                    </p>
                                    <p class="text-xs lg:text-sm text-gray-400">商品已失效</p>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
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

            <x-input-error :messages="$errors->get('items')" />

            <div class="mt-5">
                <x-primary-button value="确认订单" class="w-full text-sm font-bold h-14"
                                  wire:click.prevent="checkoutOrder"
                                  :disabled="$this->validItems()->isEmpty()"
                />
            </div>
        </div>
    </div>

    <div wire:loading class="absolute size-full bg-white/80"></div>
</div>
