<div class="container flex mt-14">
    <x-profile.nav />

    <div class="flex-1 sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow border">
            <div class="mx-auto">
                <section>
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            我的订单
                        </h2>
                    </header>

                    <table class="mt-6 w-full text-sm">
                        @foreach($orders as $order)
                            <tbody>
                                <tr class="text-xs bg-gray-100 text-gray-600">
                                    <td class="py-1 px-6" colspan="5">
                                        <span>{{ $order->created_at }}</span>
                                        <span class="ms-2">订单号：<strong>{{ $order->no }}</strong></span>
                                    </td>
                                </tr>
                                <tr class="border border-t-0 *:border-x *:text-center">
                                    <td>
                                        <ul>
                                            @foreach($order->items as $item)
                                                <li class="flex justify-around border-b last:border-b-0 px-6 py-4 gap-x-4 text-left">
                                                    <div class="flex items-center gap-x-4">
                                                        <div>
                                                            <a href="{{ route('products.show', [$item->sku_snapshot['product']['id']]) }}"
                                                               wire:navigate
                                                               class="block relative size-24"
                                                            >
                                                                <x-image-placeholder iconSize="6" />
                                                                @if($image = $order->product?->getFirstMediaUrl('product-images'))
                                                                    <div
                                                                        class="top-0 absolute bg-black size-full flex items-center">
                                                                        <x-lazy-image :src="$image" />
                                                                    </div>
                                                                @endif
                                                            </a>

                                                        </div>
                                                        <div class="flex flex-col w-72">
                                                            <a href="{{ route('products.show', [$item->sku_snapshot['product']['id']]) }}"
                                                               wire:navigate
                                                               class="hover:text-active text-wrap"
                                                            >
                                                                {{ $item->sku_snapshot['product']['title'] }}
                                                            </a>
                                                            <span class="text-gray-400">
                                                                {{ $item->sku_snapshot['name'] }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="self-center">
                                                        <span>x{{ $item->quantity }}</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="leading-[-100%]">
                                        {{ $order->address['contact_name'] }}
                                    </td>
                                    <td>
                                        ￥{{ $order->amount }}
                                    </td>
                                    <td>
                                        <div class="flex flex-col">
                                            @if($order->paid_at)
                                                @switch($order->ship_status)
                                                    @case(\App\Enums\OrderShipStatus::PENDING) 已支付 @break
                                                    @case(\App\Enums\OrderShipStatus::DELIVERED) 已发货 @break
                                                    @case(\App\Enums\OrderShipStatus::RECEIVED) 已收货 @break
                                                @endswitch

                                            @elseif($order->closed)
                                                已关闭
                                            @else
                                                <span>未支付</span>
                                                <span>
                                                    请于 {{ $order->paid_expired_at->format('H:i') }} 前完成支付
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.show', [$order]) }}"
                                           wire:navigate
                                           class="hover:text-active"
                                        >
                                            查看订单
                                        </a>
                                    </td>
                                </tr>
                                <tr class="h-4"></tr>
                            </tbody>
                        @endforeach
                    </table>

                    <div class="mt-6">
                        {{ $orders->links() }}
                    </div>

                </section>
            </div>
        </div>
    </div>
</div>
