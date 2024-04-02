@props([
    'min' => 0,
    'max',
])

<div
    x-data="numberInput({
        min: @js($min),
        max: @js($max),
    })"
    x-bind="wrapper"
    {{ $attributes->twMerge('relative flex justify-between items-center bg-white border w-24 md:w-44') }}
>
    <button type="button" class="p-1 md:p-3 h-full" x-ref="decrBtn">
        <x-heroicon-o-minus class="size-4 md:size-6"/>
    </button>
    <input
        type="text"
        class="h-11 text-center block flex-1 w-8 md:w-10 p-0 border-none ring-0 focus:ring-0"
        x-bind="input"
    />
    <button type="button" class="p-1 md:p-3 h-full" x-ref="incrBtn">
        <x-heroicon-o-plus class="size-4 md:size-6"/>
    </button>
</div>
