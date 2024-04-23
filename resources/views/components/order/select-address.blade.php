@props([
    'addresses'
])

<section
    x-data="{ address: null }"
    x-modelable="address"
    {{ $attributes->except(['x-data', 'x-modelable'])->twMerge('container border p-10 my-6') }}
>
    <h2 class="text-xl font-bold my-3">选择配送地址</h2>
    @if($addresses && count($addresses) > 0)
        <ul>
            @foreach($addresses as $address)
                <li>
                    <label class="flex items-center gap-3 hover:bg-gray-100 p-1.5">
                        <input
                            type="radio"
                            x-model="address" value="{{ $address->id }}"
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
    @else
        <div class="flex justify-center items-center">
            <a href="{{ route('user_addresses.index') }}" wire:navigate>请新建收货地址</a>
        </div>
    @endif

</section>