<div class="container mt-14 relative">
    <h1 class="text-2xl font-bold my-6">确认订单</h1>

    <form wire:submit="createOrder">
        <x-order.select-address wire:model.live="addressId" :addresses="$this->addresses" />

        <section class="container border p-10 my-6">
            <h2 class="text-xl font-bold my-3">物品清单</h2>
            <ul>
                <li class="flex justify-around py-6">
                    <div class="w-1/4 flex justify-center items-center">
                        @if($image = $this->sku->product->getFirstMediaUrl())
                            <img src="{{ $image }}" />
                        @else
                            <div class="bg-gray-300 min-w-24 min-h-24 flex items-center justify-center">
                                <x-heroicon-o-photo class="size-4" />
                            </div>
                        @endif
                    </div>

                    <div class="w-1/4 flex justify-center items-center">
                        <div>
                            <div>{{ $this->sku->product->title }}</div>
                            <div>{{ $this->sku->name }}</div>
                        </div>
                    </div>

                    <div class="w-1/4 flex justify-center items-center text-active font-bold">
                        ￥{{ $this->sku->price }}</div>

                    <div class="w-1/4 flex justify-center items-center">x{{ $quantity }}</div>
                </li>
            </ul>
        </section>

        <x-order.info-confirm :total="$this->totalAmount" :currentAddress="$this->currentAddress" />

        <section class="flex items-center justify-end gap-6">
            <x-primary-button type="submit" value="提交订单" />
        </section>
    </form>

</div>
