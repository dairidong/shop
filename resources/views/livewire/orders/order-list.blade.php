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
                                                    @case(\App\Enums\OrderShipStatus::DELIVERED)
                                                        <span>已发货</span>
                                                        <x-primary-button value="确认收货"
                                                                          class="text-xs font-bold bg-active hover:bg-active/75 py-1 px-0 m-2"
                                                                          @click="$dispatch('open-modal', 'confirm-receive-order-{{ $order->no }}')"
                                                        />

                                                        <x-modal name="confirm-receive-order-{{ $order->no }}">
                                                            <div class="p-6 flex flex-col items-center">
                                                                <x-heroicon-o-information-circle
                                                                    class="size-20 text-gray-400" />

                                                                <h2 class="text-lg font-bold text-gray-900 mt-6">
                                                                    确认收货
                                                                </h2>

                                                                <div
                                                                    class="my-6 text-sm text-gray-600 flex flex-col gap-2">
                                                                    <span>订单：{{ $order->no }}</span>
                                                                    <span>确认收货不可撤销，请确定已收到商品。</span>
                                                                </div>

                                                                <div class="mt-6 flex gap-6">
                                                                    <x-secondary-button x-on:click="$dispatch('close')">
                                                                        {{ __('Cancel') }}
                                                                    </x-secondary-button>

                                                                    <x-danger-button class="ms-3"
                                                                                     wire:click.prevent="receive({{ $order->id }})">
                                                                        {{ __('Confirm') }}
                                                                    </x-danger-button>
                                                                </div>
                                                            </div>
                                                        </x-modal>

                                                        @break
                                                    @case(\App\Enums\OrderShipStatus::RECEIVED)
                                                        @if($order->reviewed)
                                                            <span>已完成</span>
                                                        @else
                                                            <span>待评价</span>
                                                            <a class="m-auto" wire:click
                                                               href="{{ route('orders.review',[$order]) }}">
                                                                <x-primary-button value="评价"
                                                                                  class="text-xs font-bold bg-active hover:bg-active/75 py-1 px-2 m-2"
                                                                />
                                                            </a>

                                                        @endif
                                                        @break
                                                @endswitch

                                            @elseif($order->closed)
                                                已关闭
                                            @elseif(now()->isAfter($order->paid_expired_at))
                                                支付取消
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
