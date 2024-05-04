@props([
    'iconSize' => '16'
])

<div {{ $attributes->twMerge("flex items-center justify-center size-full bg-gray-200") }}>
    <x-heroicon-o-photo class="size-{{ $iconSize }}" />
</div>