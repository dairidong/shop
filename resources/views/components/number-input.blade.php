@php use Illuminate\Support\Str; @endphp
@props([
    'id' => 'quantity-' . Str::random(6),
    'min' => 0,
    'max',
    'default' => 0
])

<div class="relative flex justify-between items-center bg-white border w-24 md:w-44">
    <button type="button"
            data-input-counter-decrement="{{ $id }}"
            class="p-1 md:p-3 h-full">
        <x-heroicon-o-minus class="size-4 md:size-6"/>
    </button>
    <input
        type="text" id="{{ $id }}"
        data-input-counter
        class="h-11 text-center block w-8 md:w-10 p-0 border-none ring-0 focus:ring-0"
        value="{{ $default }}"
        @isset($min) data-input-counter-min="{{ $min }}" @endisset
        @isset($max) data-input-counter-max="{{ $max }}" @endisset
        {{ $attributes }}
    />
    <button type="button"
            data-input-counter-increment="{{ $id }}"
            class="p-1 md:p-3 h-full">
        <x-heroicon-o-plus class="size-4 md:size-6"/>
    </button>
</div>
