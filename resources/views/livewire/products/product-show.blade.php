<div x-data="{
        price: @js($product->price),
        productPrice: @js($product->price),
        addedCart: false,
     }"
     x-on:add-to-cart="addedCart = true"
>
    <div class="bg-[#f3f3f3]">
        <template  x-if="addedCart" >
            <div class="container pt-10" @click="addedCart = false">
                <x-auth-session-status :status="__('Has been added to your cart!')" type="danger" />
            </div>
        </template>
        <div class="flex flex-col lg:flex-row gap-x-2 gap-y-12 container py-14 px-6">
            <x-product.carousel :images="$this->images" />

            <section class="flex flex-col gap-20 w-full lg:w-1/2 l lg:px-8">
                <div>
                    <h1 class="font-bold text-2xl mb-2">{{ $product->long_title }}</h1>
                    <p class="text-2xl" x-text="`￥${price}`"></p>
                </div>

                @if($this->skus->sum('stock') <= 0)
                    <div class="flex flex-col justify-end min-h-[60%]">
                        <p>{{ __('Out of stock') }}</p>

                        <div class="flex items-center gap-2 text-gray-800 mt-4">
                            <x-heroicon-o-heart class="size-4" />

                            <p class="text-xs">{{ __('Add to Wishlist') }}</p>
                        </div>
                    </div>
                @else
                    <form
                        x-data="{
                            attributeGroups: @js($this->attributeGroups),
                            skus: @js($this->skus),
                            currentSku: null,
                            selected: {},
                            enabledAttributes: {},
                            selectedToArray(selected) {
                                return Object.entries(selected).map(
                                    ([groupId, attrId]) => ({groupId: parseInt(groupId), attrId})
                                ).filter((s) => s.attrId);
                            },
                            getAvailableAttributes(selectedAttributes) {
                                const availableAttributes = {};

                                this.attributeGroups.forEach((group) => {
                                    availableAttributes[group.id] = [];
                                    const otherGroupSelectedAttributes = selectedAttributes.filter((attr) => attr.groupId !== group.id);
                                    this.skus.forEach((sku) => {
                                        if(sku.stock <= 0) return;

                                        const isMatch = otherGroupSelectedAttributes.every((attr) => {
                                            return sku.attributes.find(
                                                (skuAttr) => skuAttr.id === attr.attrId && skuAttr.product_attribute_group_id === attr.groupId
                                            );
                                        });

                                        if(isMatch) {
                                            availableAttributes[group.id].push(
                                                sku.attributes.find((attr) => attr.product_attribute_group_id === group.id).id
                                            );
                                        }
                                    });

                                    availableAttributes[group.id] = unique(availableAttributes[group.id]);
                                });

                                return availableAttributes;
                            }
                        }"
                        x-init="
                            selected = Object.fromEntries(attributeGroups.map((group) => [group.id, null]));
                            enabledAttributes = getAvailableAttributes(selectedToArray(selected));
                            $watch('selected', (value) => {
                                const selectedAttributes = selectedToArray(value);

                                enabledAttributes = getAvailableAttributes(selectedAttributes);

                                if(selectedAttributes.length === attributeGroups.length){
                                    const selectedSku = skus.find((sku) => {
                                       return selectedAttributes.every((attr) => {
                                            return sku.attributes.find(
                                                (skuAttr) => skuAttr.id === attr.attrId && skuAttr.product_attribute_group_id === attr.groupId
                                            );
                                       });
                                    });

                                   currentSku = selectedSku;
                               } else {
                                   currentSku = null;
                               }
                            });

                            $watch('currentSku', (value) => {
                                if(value === null) {
                                    $wire.skuId = null;
                                    price = productPrice;
                                } else {
                                    $wire.skuId = value.id;
                                    price = value.price;
                                }
                            })
                        "
                        wire:submit="createOrder"
                        class="flex flex-col gap-12"
                    >
                        <div class="flex flex-col justify-center flex-1 gap-4">
                            <template x-for="group in attributeGroups" :key="group.id">
                                <div>
                                    <p x-text="group.name" class="mb-2 text-sm"></p>
                                    <ul class="flex gap-4">
                                        <template x-for="attribute in group.attributes"
                                                  :key="attribute.id">
                                            <li>
                                                <input
                                                    type="radio"
                                                    :value="attribute.id"
                                                    x-model.number="selected[group.id]"
                                                    :name="`group-${group.id}`"
                                                    :disabled="!enabledAttributes[group.id].find((id) => attribute.id === id)"
                                                    class="hidden peer"
                                                    required
                                                />
                                                <label
                                                    class="inline-flex items-center justify-between px-6 py-2 lg:px-4 lg:py-1 text-sm bg-white border cursor-pointer select-none peer-checked:bg-black peer-checked:text-white peer-disabled:cursor-not-allowed peer-disabled:text-gray-400 peer-disabled:hover:bg-white hover:text-white hover:bg-active"
                                                    x-text="attribute.value"
                                                    x-on:click.prevent="
                                                        if($el.previousElementSibling.disabled){
                                                            return;
                                                        }
                                                        selected[group.id] = selected[group.id] === attribute.id
                                                            ? null
                                                            : attribute.id;
                                                    "
                                                ></label>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                                <span x-text="group"></span>
                            </template>
                        </div>

                        <div>
                            <div class="mb-1">
                                <span class="text-gray-800 text-xs" x-text="currentSku ? `{{ __('Left stock') }} ${currentSku.stock}` : ''"></span>
                            </div>
                            <div class="flex gap-2">
                                <x-number-input :min="1" :max="0"
                                                x-init="$watch('currentSku', (value) => {
                                                    max = value ? value.stock : 1;
                                                })"
                                                wire:model.number="quantity"
                                />

                                <x-primary-button
                                    type="button"
                                    :value="__('ADD TO CART')"
                                    x-bind:disabled="!$wire.skuId || $wire.quantity <= 0"
                                    wire:loading.attr="disabled"
                                    class="min-w-48 font-bold text-sm flex-1 md:flex-none disabled:cursor-not-allowed disabled:bg-neutral-400"
                                    wire:click="addToCart"
                                />
                            </div>

                            <div class="flex items-center gap-2 text-gray-800 mt-4">
                                <x-heroicon-o-heart class="size-4" />

                                <p class="text-xs">{{ __('Add to Wishlist') }}</p>
                            </div>

                            <x-primary-button
                                type="submit"
                                :value="__('BUY NOW')"
                                wire:loading.attr="disabled"
                                x-bind:disabled="!$wire.skuId || $wire.quantity <= 0"
                                class="w-full font-bold text-sm py-4 mt-6 disabled:cursor-not-allowed disabled:bg-neutral-400"
                            />
                        </div>
                    </form>
                @endif
            </section>
        </div>
    </div>

    <div class="px-6">
        <div
            x-data="{
                currentTab: null,
                tabs: [
                    { key: 'description', label: @js(__('Description')) },
                    { key: 'reviews', label: @js(__('Reviews')) },
                ],
                setTab(key) {
                    this.currentTab = key;
                    window.location.hash = key;
                },
            }"
            x-init="
                let tab = tabs[0]
                if(window.location.hash){
                    const hash = window.location.hash.slice(1);
                    tab = tabs.find((tab) => tab.key === hash) ?? tab;
                }
                currentTab = tab.key;
            "
            class="container py-14"
        >
            <ul class="flex justify-center gap-16 text-lg *:cursor-pointer">
                <template x-for="tab in tabs">
                    <li :class="{'text-active': tab.key === currentTab}" @click.prevent="setTab(tab.key)"
                        x-text="tab.label"></li>
                </template>
            </ul>

            <div class="max-w-[770px] mx-auto py-6">
                <section x-show="currentTab === 'description'" x-cloak>
                    @if($product->description === '')
                        <p class="text-gray-400 mx-auto text-center">
                            {{ __("The product doesn't have description yet.") }}
                        </p>
                    @else
                        {!! $product->description !!}
                    @endif

                </section>

                <section x-show="currentTab === 'reviews'" x-cloak>
                    <ul>
                        <li class="flex gap-8">
                            {{--<x-lazy-image />--}}
                            <x-lazy-image :src="url('default_avatar.png')" class="block size-16 rounded-full" />
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-3">
                                    <div class="flex *:-m-0.5">
                                        <template x-for="i in 5">
                                            <x-heroicon-s-star class="size-6 text-yellow-500" />
                                        </template>
                                    </div>
                                    <div>
                                        <strong>nambui</strong> - <span class="text-gray-400">2024-04-12</span>
                                    </div>
                                </div>
                                <p>
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea
                                </p>
                            </div>
                        </li>
                    </ul>
                </section>
            </div>
        </div>
    </div>
</div>
