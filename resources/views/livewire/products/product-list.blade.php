<div class="container flex gap-6 mt-14">
    <aside class="hidden lg:block lg:w-1/4">
        <div>
            <div>
                <div x-data="{ expanded: true}">
                    <div class="flex items-center justify-between py-3 cursor-pointer" @click="expanded = ! expanded">
                        <h6 class="text-lg font-bold">{{ __('Search') }}</h6>
                        <x-heroicon-s-chevron-down class="size-4 transition-transform"
                                                   x-bind:class="expanded ? '' : 'rotate-180'" />
                    </div>
                    <div class="relative w-full" x-show="expanded" x-collapse>
                        <input type="text"
                               @keyup.enter="$wire.commit()"
                               wire:model="search"
                               class="block w-full text-sm text-gray-900 rounded-sm border border-gray-300 focus:border-gray-600 focus:ring-0 focus:shadow-none"
                               placeholder="{{ __('Search Product...') }}"
                        />
                        <button wire:click="$commit"
                                class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-neutral-600">
                            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <div class="w-full px-3">
        @if($products->isNotEmpty())
            <secion class="flex justify-between items-center text-sm text-gray-600 mb-10">
                <div class="block lg:hidden">
                    <button class="flex items-center gap-2 border px-5 py-3">
                        <x-heroicon-o-funnel class="size-4" />
                        <span>{{ __('Filter') }}</span>
                    </button>
                </div>

                <div class="hidden lg:block">
                    {{ __('Showing Results', ['start' => $products->firstItem(), 'end' => $products->lastItem(), 'total' => $products->total()]) }}
                </div>

                <div class="text-right">
                    <select wire:model.live="sort"
                            class="border border-gray-300 focus-visible:border-gray-300 focus:ring-0 text-sm w-3/4 sm:w-full">
                        @foreach(\App\Enums\ProductSort::cases() as $sort)
                            <option value="{{ $sort->value }}">{{ $sort->translateLabel() }}</option>
                        @endforeach
                    </select>
                </div>
            </secion>

            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <livewire:products.components.product-list-item :$product :key="$product->id" />
                @endforeach
            </section>

            <section class="my-10">
                {{ $products->links() }}
            </section>

        @else
            <x-alert>
                no products found
            </x-alert>
        @endif
    </div>
</div>
