<div class="container flex mt-14">
    <aside class="hidden lg:block lg:w-1/4">
        <div>
            <div>{{ __('Search') }}</div>
        </div>
    </aside>

    <div class="w-full px-3">
        @if($products->isNotEmpty())
            <secion class="flex justify-between text-sm text-gray-600 mb-10">
                <div>
                    {{ __('Showing Results', ['start' => $products->firstItem(), 'end' => $products->lastItem(), 'total' => $products->total()]) }}
                </div>

                <div>

                </div>
            </secion>


            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                    <livewire:products.components.product-list-item :$product  :key="$product->id"/>
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
