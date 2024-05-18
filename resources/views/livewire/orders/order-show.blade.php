<div class="container flex mt-14">
    <div class="flex-1 sm:px-6 lg:px-8 space-y-6">

        {{--  Breadcrumb  --}}
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <a href="/"
                       wire:navigate
                       class="inline-flex items-center text-sm font-medium flex-nowrap text-gray-700 hover:text-active"
                    >
                        <x-heroicon-m-home class="size-4" />
                        首页
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('orders.index') }}"
                           wire:navigate
                           class="ms-1 text-sm font-medium text-gray-700 hover:text-active md:ms-2">我的订单</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">订单 {{ $order->no }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        {{-- Stepper --}}
        <div class="p-4 sm:p-8 bg-white shadow border">
            <div class="mx-auto">
                <section>
                    <ol class="flex items-center w-full text-sm font-medium text-center text-gray-500 sm:text-base">
                        <li class="flex md:w-full items-center sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <div
                                class="flex flex-col items-center gap-2 text-nowrap after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 data-[active]:text-emerald-700 data-[active]:font-bold"
                                data-active
                            >
                                <x-heroicon-s-pencil-square class="size-6" />
                                <span>提交订单</span>
                                <span class="text-xs font-normal text-gray-500">{{ $order->created_at }}</span>
                            </div>
                        </li>
                        <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <div
                                class="flex flex-col items-center gap-2 text-nowrap after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 data-[state=active]:text-emerald-700 data-[state=active]:font-bold data-[state=closed]:text-active data-[state=warning]:text-[#d97706] data-[state=warning]:font-bold"
                                @if($order->paid_at)
                                    data-state="active"
                                @elseif($order->closed)
                                    data-state="closed"
                                @elseif((now()->isAfter($order->paid_expired_at)))
                                    data-state="warning"
                                @endif
                            >
                                @if($order->paid_at)
                                    <x-heroicon-o-credit-card class="size-6" />
                                    <span>付款成功</span>
                                    <span class="text-xs font-normal text-gray-500">{{ $order->paid_at }}</span>
                                @elseif($order->closed)
                                    <x-heroicon-o-x-mark class="size-6" />
                                    <span>订单关闭</span>
                                @elseif(is_null($order->paid_at) && now()->isAfter($order->paid_expired_at))
                                    <x-heroicon-o-clock class="size-6" />
                                    <span>支付已超时</span>
                                @else
                                    <x-heroicon-o-credit-card class="size-6" />
                                    <span>待付款</span>
                                    <a href="{{ route('payment.alipay',[$order]) }}">
                                        <x-primary-button value="立即付款"
                                                          class="text-xs bg-active hover:bg-active/75 px-4 py-1" />
                                    </a>
                                    <span class="text-xs font-normal text-gray-500">请于 {{ $order->paid_expired_at->format('H:i') }} 前完成支付</span>
                                @endif
                            </div>
                        </li>
                        <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <div
                                class="flex flex-col items-center gap-2 text-nowrap after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 data-[active]:text-emerald-700 data-[active]:font-bold"
                                @if($order->paid_at && $order->isAfterShipPending()) data-active @endif
                            >
                                <x-heroicon-o-cube class="size-6" />
                                <span>商品发货</span>
                            </div>
                        </li>
                        <li class="flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-gray-200 after:border-1 after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <div
                                class="flex flex-col items-center gap-2 text-nowrap after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 data-[active]:text-emerald-700 data-[active]:font-bold"
                                @if($order->isAfterShipDelivered()) data-active @endif
                            >
                                <x-heroicon-o-truck class="size-6" />
                                <span>商品配送中</span>
                            </div>
                        </li>

                        <li class="flex items-center">
                            <div
                                class="flex flex-col items-center gap-2 text-nowrap after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 data-[active]:text-emerald-700 data-[active]:font-bold"
                                @if($order->isFinish()) data-active @endif
                            >
                                <x-heroicon-o-document-check class="size-6" />
                                <span>订单完成</span>
                            </div>
                        </li>
                    </ol>
                </section>
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow border grid grid-cols-2">
            <div class="border-r p-4">
                <header>
                    <h3 class="font-medium text-gray-900">
                        收货人信息
                    </h3>
                </header>

                <section class="flex flex-col p-4 gap-1 text-gray-500 text-sm">
                    <div>收货人：<span class="text-black text-base">{{ $order->address['contact_name'] }}</span></div>
                    <div>联系电话：<span class="text-black text-base">{{ $order->address['contact_phone'] }}</span></div>
                    <div>邮编： <span class="text-black text-base">{{ $order->address['zip'] }}</span></div>
                    <div class="col-span-3">
                        收货地址：<span class="text-black text-base">{{ $order->address['address'] }}</span>
                    </div>
                </section>
            </div>

            <div class="p-4">
                <header>
                    <h3 class="font-medium text-gray-900">
                        订单信息
                    </h3>
                </header>

                <section class="flex flex-col p-4 gap-1 text-gray-500 text-sm">
                    <div>
                        订单状态：
                        <span class="text-black text-base">
                            @if($order->paid_at)
                                @switch($order->ship_status)
                                    @case(\App\Enums\OrderShipStatus::PENDING) 未支付 @break
                                    @case(\App\Enums\OrderShipStatus::DELIVERED) 已发货 @break
                                    @case(\App\Enums\OrderShipStatus::RECEIVED) 已收货 @break
                                @endswitch

                            @elseif($order->closed)
                                已关闭
                            @else
                                未支付
                            @endif
                        </span>
                    </div>
                    <div>总计：<strong class="text-active text-lg">￥{{ $order->amount }}</strong></div>
                    <div>
                        下单时间：
                        <span class="text-black text-base">{{ $order->created_at }}</span>
                    </div>
                    <div>订单号： <span class="text-black text-base">{{ $order->no }}</span></div>
                </section>
            </div>
        </div>

        <div>
            <table class="w-full border border-collapse text-center">
                <thead>
                    <tr class="border-b bg-black text-white *:py-2">
                        <th>商品</th>
                        <th>商品价格</th>
                        <th>商品数量</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="border-b *:py-6">
                            <td>
                                <div class="flex items-center justify-center">
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
                            </td>
                            <td>{{ $item->price }}</td>
                            <td>x{{ $item->quantity }}</td>
                            <td>
                                <div>退/换货</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <section class="flex items-center justify-end gap-6 bg-gray-100 p-6">
                <div class="flex items-center">
                    <span>
                        @if($order->paid_at)
                            实付款：
                        @else
                            应付总额：
                        @endif </span>
                    <strong class="text-xl text-active">￥{{ $order->amount }}</strong>
                </div>
                @if(is_null($order->paid_at) && now()->isBefore($order->paid_expired_at) && !$order->closed)
                    <a href="{{ route('payment.alipay',[$order]) }}">
                        <x-primary-button value="立即付款"
                                          class="text-lg font-bold bg-active hover:bg-active/75" />
                    </a>
                @endif

                @if($order->ship_status === \App\Enums\OrderShipStatus::DELIVERED)
                    <x-primary-button value="确认收货"
                                      class="text-lg font-bold bg-active hover:bg-active/75"
                                      @click="$dispatch('open-modal', 'confirm-receive-order')"
                    />

                    <x-modal name="confirm-receive-order">
                        <div class="p-6 flex flex-col items-center">
                            <x-heroicon-o-information-circle class="size-20 text-gray-400" />

                            <h2 class="text-lg font-bold text-gray-900 mt-6">
                                确认收货
                            </h2>

                            <div class="my-6 text-sm text-gray-600 flex flex-col gap-2">
                                <span>订单：{{ $order->no }}</span>
                                <span>确认收货不可撤销，请确定已收到商品。</span>
                            </div>

                            <div class="mt-6 flex gap-6">
                                <x-secondary-button x-on:click="$dispatch('close')">
                                    {{ __('Cancel') }}
                                </x-secondary-button>

                                <x-danger-button class="ms-3" wire:click.prevent="receive">
                                    {{ __('Confirm') }}
                                </x-danger-button>
                            </div>
                        </div>
                    </x-modal>
                @endif
            </section>
        </div>

    </div>
</div>
