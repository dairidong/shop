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
                <li>
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4" />
                        </svg>
                        <a href="{{ route('orders.show',[$order]) }}"
                           wire:navigate
                           class="ms-1 text-sm font-medium text-gray-500 hover:text-active md:ms-2">订单 {{ $order->no }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="ms-1 text-sm font-medium text-gray-500 md:ms-2">评价</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div>
            <table class="w-full h-full border border-collapse text-center">
                <thead>
                    <tr class="border-b bg-black text-white *:py-2">
                        <th>商品</th>
                        <th>评价</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="border-b">
                            <td class="py-12">
                                <div class="flex items-start justify-center gap-x-6 min-h-full">
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

                                    <div class="flex flex-col items-start">
                                        <a href="{{ route('products.show', [$item->sku_snapshot['product']['id']]) }}"
                                           wire:navigate
                                           class="hover:text-active text-wrap"
                                        >
                                            {{ $item->sku_snapshot['product']['title'] }}
                                        </a>
                                        <div class="my-1 space-y-0.5">
                                            <div class="flex items-center">
                                                <span class="text-gray-400 text-xs">规格：</span>
                                                <span class="text-sm text-black">
                                                {{ $item->sku_snapshot['name'] }}
                                            </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-400 text-xs">价格：</span>
                                                <span class="text-sm text-black">
                                                ￥{{ $item->price }}
                                            </span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="text-gray-400 text-xs">数量：</span>
                                                <span class="text-sm text-black">
                                                x{{ $item->quantity }}
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="py-12">
                                <div class="w-fit mx-auto">
                                    <div class="flex flex-col justify-center items-start gap-y-2">
                                        <div class="flex items-center">
                                            <label>评分：</label>
                                            <x-rating-input />
                                        </div>


                                        <div x-id="['review']" class="flex items-start">
                                            <label :for="$id('review')">评论：</label>
                                            <textarea
                                                :id="$id('review')"
                                                placeholder="分享您的体验心得，输入评论"
                                                class="resize-none focus:border-black focus:ring-black text-sm w-96 h-32"></textarea>
                                        </div>

                                    </div>
                                </div>


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <section class="flex items-center justify-end gap-6 bg-gray-100 p-6">
                <x-primary-button value="提交评价"
                                  class="text-lg font-bold bg-active hover:bg-active/75" />
            </section>
        </div>

    </div>
</div>
