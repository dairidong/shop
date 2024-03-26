<div class="container flex gap-6 mt-14">
    <aside class="hidden lg:flex lg:w-1/4 flex-col gap-4">
        {{--          Search           --}}
        <div x-data="{ expanded: true }">
            <div class="flex items-center justify-between py-3 cursor-pointer" @click="expanded = ! expanded">
                <h6 class="text-lg font-bold">{{ __('Search') }}</h6>
                <x-heroicon-s-chevron-down class="size-4 transition-transform"
                                           x-bind:class="expanded ? '' : 'rotate-180'" />
            </div>
            <div class="relative w-full" x-show="expanded" x-collapse>
                <form x-data wire:submit="$refresh">
                    <input type="text"
                           wire:model="search"
                           class="block w-full text-sm text-gray-900 rounded-sm border border-gray-300 focus:border-gray-600 focus:ring-0 focus:shadow-none"
                           placeholder="{{ __('Search Product...') }}"
                    />
                    <button type="submit"
                            class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-neutral-600">
                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        {{--         Categories        --}}
        <div x-data="{ expanded: true }">
            <div class="flex items-center justify-between py-3 cursor-pointer" @click="expanded = ! expanded">
                <h6 class="text-lg font-bold">{{ __('Categories') }}</h6>
                <x-heroicon-s-chevron-down class="size-4 transition-transform"
                                           x-bind:class="expanded ? '' : 'rotate-180'" />
            </div>
            <div class="relative w-full" x-show="expanded" x-collapse>
                <ul class="text-gray-500">
                    @foreach($categories as $category)
                        <li>
                            <label class="flex items-center justify-between gap-3 w-full text-sm cursor-pointer">
                                <span class="flex items-center gap-3">
                                    <input
                                        type="checkbox"
                                        wire:model.live.number="checkedCategories"
                                        value="{{ $category->id }}"
                                        class="ring-0 focus:ring-0 border-2 border-gray-600 focus:border-gray-600 text-gray-600"
                                    />
                                    <span>{{ $category->name }}</span>
                                </span>

                                <span class="text-xs">({{ $category->products_count }})</span>
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{--            Price          --}}
        <div x-data="{ expanded: true }">
            <div class="flex items-center justify-between py-3 cursor-pointer" @click="expanded = ! expanded">
                <h6 class="text-lg font-bold">{{ __('Price') }}</h6>
                <x-heroicon-s-chevron-down class="size-4 transition-transform"
                                           x-bind:class="expanded ? '' : 'rotate-180'" />
            </div>

            <div class="relative w-full pt-11" x-show="expanded" x-collapse>
                <div
                    x-data="{
                        min: 0,
                        max: @js($maxPrice),
                        currentMin: $wire.entangle('min').live,
                        currentMax: $wire.entangle('max').live,
                        formatter() {
                            return {
                                to: (value) => parseInt(value)
                            }
                        },
                        destroy() {
                            if($el.noUiSlider) {
                                $el.noUiSlider.destroy();
                            }
                        }
                    }"
                    x-init="
                        noUiSlider.create($el,{
                            start: [currentMin, currentMax > 0 ? currentMax : max],
                            step: 1,
                            connect: true,
                            tooltips: [formatter(), formatter()],
                            range: { min, max }
                        });
                        $el.noUiSlider.on('end', (values, handle, unencoded, tap, positions, noUiSlider) => {
                            currentMin = unencoded[0];
                            currentMax = unencoded[1]
                        });

                        $watch('currentMin', function(value) {
                            if($el.noUiSlider) {
                                $el.noUiSlider.set([value]);
                            }
                        });

                        $watch('currentMax', function(value) {
                            if($el.noUiSlider) {
                                $el.noUiSlider.set([null, value]);
                            }
                        });
                    "
                    wire:ignore
                ></div>
            </div>
        </div>
    </aside>

    <div class="w-full px-3">
        <secion class="flex justify-between items-center text-sm text-gray-600 mb-10">
            <div class="block lg:hidden">
                <x-drawer @close-filter-drawer.window="$dispatch('close')">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 border px-5 py-3">
                            <x-heroicon-o-funnel class="size-4" />
                            <span>{{ __('Filter') }}</span>
                        </button>
                    </x-slot>

                    <x-slot
                        name="body"
                        class="flex flex-col gap-6 px-6 w-7/12 lg:hidden"
                    >
                        {{--          Search           --}}
                        <div x-data="{ expanded: true }">
                            <div class="flex items-center justify-between py-3 cursor-pointer"
                                 @click="expanded = ! expanded">
                                <h6 class="text-lg font-bold">{{ __('Search') }}</h6>
                                <x-heroicon-s-chevron-down class="size-4 transition-transform"
                                                           x-bind:class="expanded ? '' : 'rotate-180'" />
                            </div>
                            <div class="relative w-full" x-show="expanded" x-collapse>
                                <form x-data wire:submit="$refresh">
                                    <input type="text"
                                           wire:model="search"
                                           class="block w-full text-sm text-gray-900 rounded-sm border border-gray-300 focus:border-gray-600 focus:ring-0 focus:shadow-none"
                                           placeholder="{{ __('Search Product...') }}"
                                    />
                                    <button type="submit"
                                            class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-neutral-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{--         Categories        --}}
                        <div x-data="{ expanded: true }">
                            <div class="flex items-center justify-between py-3 cursor-pointer"
                                 @click="expanded = ! expanded">
                                <h6 class="text-lg font-bold">{{ __('Categories') }}</h6>
                                <x-heroicon-s-chevron-down class="size-4 transition-transform"
                                                           x-bind:class="expanded ? '' : 'rotate-180'" />
                            </div>
                            <div class="relative w-full" x-show="expanded" x-collapse>
                                <ul class="text-gray-500">
                                    @foreach($categories as $category)
                                        <li>
                                            <label class="flex items-center justify-between gap-3 w-full text-sm cursor-pointer" @click="open = false">
                                                <span class="flex items-center gap-3">
                                                    <input
                                                        type="checkbox"
                                                        wire:model.live.number="checkedCategories"
                                                        value="{{ $category->id }}"
                                                        class="ring-0 focus:ring-0 border-2 border-gray-600 focus:border-gray-600 text-gray-600"
                                                    />
                                                    <span>{{ $category->name }}</span>
                                                </span>

                                                <span class="text-xs">({{ $category->products_count }})</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        {{--            Price          --}}
                        <div x-data="{ expanded: true }">
                            <div class="flex items-center justify-between py-3 cursor-pointer"
                                 @click="expanded = ! expanded">
                                <h6 class="text-lg font-bold">{{ __('Price') }}</h6>
                                <x-heroicon-s-chevron-down class="size-4 transition-transform"
                                                           x-bind:class="expanded ? '' : 'rotate-180'" />
                            </div>

                            <div class="relative w-full pt-9" x-show="expanded" x-collapse>
                                <div
                                    x-data="{
                                        min: 0,
                                        max: @js($maxPrice),
                                        currentMin: $wire.entangle('min').live,
                                        currentMax: $wire.entangle('max').live,
                                        formatter() {
                                            return {
                                                to: (value) => parseInt(value)
                                            }
                                        },
                                        destroy() {
                                            if($el.noUiSlider) {
                                                $el.noUiSlider.destroy();
                                            }
                                        }
                                    }"
                                    x-init="
                                        noUiSlider.create($el,{
                                            start: [currentMin, currentMax > 0 ? currentMax : max],
                                            step: 1,
                                            connect: true,
                                            tooltips: [formatter(), formatter()],
                                            range: { min, max }
                                        });
                                        $el.noUiSlider.on('end', (values, handle, unencoded, tap, positions, noUiSlider) => {
                                            currentMin = unencoded[0];
                                            currentMax = unencoded[1]
                                        });

                                        $watch('currentMin', function(value) {
                                            if($el.noUiSlider) {
                                                $el.noUiSlider.set([value]);
                                            }
                                        });

                                        $watch('currentMax', function(value) {
                                            if($el.noUiSlider) {
                                                $el.noUiSlider.set([null, value]);
                                            }
                                        });
                                    "
                                    wire:ignore
                                ></div>
                            </div>
                        </div>
                    </x-slot>
                </x-drawer>
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

        @if($products->isNotEmpty())
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

    <div wire:loading class="absolute w-full h-full top-0 lg:top-20 left-0 bg-black/10 z-[1001] overflow-hidden"></div>
</div>
