<div class="container mt-14 relative">
    <h1 class="text-2xl font-bold my-6">确认订单</h1>

    <form wire:submit="createOrder">
        <section class="container border p-10 my-6">
            <h2 class="text-xl font-bold my-3">选择配送地址</h2>
            <ul>
                @foreach($this->addresses as $address)
                    <li>
                        <label class="flex items-center gap-3 hover:bg-gray-100 p-1.5">
                            <input
                                type="radio"
                                wire:model.fill="addressId" value="{{ $address->id }}"
                                class="text-black focus:ring-offset-0 focus:ring-0"
                            >

                            <div class="flex gap-4">
                                <div>{{ $address->contact_name }}</div>
                                <div>{{ $address->full_address }}</div>
                                <div>{{ $address->contact_phone }}</div>
                            </div>
                        </label>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="container border p-10 my-6">
            <h2 class="text-xl font-bold my-3">物品清单</h2>
            <ul>
                @foreach($items as $item)
                    <li class="flex justify-around py-6">
                        <div class="w-1/4 flex justify-center items-center">
                            @if($image = $item->product->getFirstMediaUrl())
                                <img src="{{ $image }}" />
                            @else
                                <div class="bg-gray-300 min-w-24 min-h-24 flex items-center justify-center">
                                    <x-heroicon-o-photo class="size-4" />
                                </div>
                            @endif
                        </div>

                        <div class="w-1/4 flex justify-center items-center">
                            <div>
                                <div>{{ $item->product->title }}</div>
                                <div>{{ $item->product_sku->name }}</div>
                            </div>
                        </div>

                        <div class="w-1/4 flex justify-center items-center text-active font-bold">￥{{ $item->product_sku->price }}</div>

                        <div class="w-1/4 flex justify-center items-center">x{{ $item->quantity }}</div>
                    </li>
                @endforeach
            </ul>
        </section>

        <section class="flex flex-col items-end justify-center gap-2 my-6 bg-gray-100 py-6 px-2">
            <div class="flex items-center">
                <span>应付总额：</span>
                <strong class="text-2xl text-active">￥{{ $this->totalAmount }}</strong>
            </div>
            <div class="flex gap-6 text-gray-600">
                <div>寄送至：{{ $this->currentAddress->full_address }}</div>
                <div>收件人：{{ $this->currentAddress->contact_name }} {{ $this->currentAddress->contact_phone }}</div>
            </div>
        </section>

        <section class="flex items-center justify-end gap-6">
            <a class="hover:text-active underline" href="{{ route('cart') }}" wire:navigate>返回购物车</a>
            <x-primary-button type="submit" value="提交订单" />
        </section>
    </form>

</div>
