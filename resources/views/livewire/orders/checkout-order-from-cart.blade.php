<div class="container mt-14 relative">
    <h1 class="text-2xl font-bold my-6">确认订单</h1>

    <form wire:submit="createOrder">
        <x-order.select-address wire:model.live="addressId" :addresses="$this->addresses" />

        <section class="container border p-10 my-6">
            <h2 class="text-xl font-bold my-3">物品清单</h2>
            <ul>
                @foreach($items as $item)
                    <li class="flex justify-around py-6">
                        <div class="w-1/4 flex justify-center items-center">
                            <a href="{{ route('products.show',[$item->product_sku->product->id]) }}"
                               wire:navigate>
                                @if($image = $item->product_sku->product->getFirstMediaUrl())
                                    <img src="{{ $image }}" />
                                @else
                                    <div class="bg-gray-300 min-w-24 min-h-24 flex items-center justify-center">
                                        <x-heroicon-o-photo class="size-4" />
                                    </div>
                                @endif
                            </a>

                        </div>

                        <div class="w-1/4 flex justify-center items-center">
                            <div>
                                <div>
                                    <a class="hover:text-active"
                                       href="{{ route('products.show',[$item->product_sku->product->id]) }}"
                                       wire:navigate
                                    >
                                        {{ $item->product_sku->product->title }}
                                    </a>
                                </div>
                                <div class="text-gray-400">{{ $item->product_sku->name }}</div>
                            </div>
                        </div>

                        <div class="w-1/4 flex justify-center items-center text-active font-bold">
                            ￥{{ $item->product_sku->price }}</div>

                        <div class="w-1/4 flex justify-center items-center">x{{ $item->quantity }}</div>
                    </li>
                @endforeach
            </ul>
        </section>

        <x-order.info-confirm :total="$this->totalAmount" :currentAddress="$this->currentAddress" />

        <section class="flex items-center justify-end gap-6">
            <a class="hover:text-active underline" href="{{ route('cart') }}" wire:navigate>返回购物车</a>
            <x-primary-button type="submit" value="提交订单" />
        </section>
    </form>

</div>
