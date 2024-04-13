@props(['value', 'disabled' => false])

<button {{ $attributes->twMerge('flex items-center justify-center text-white px-14 py-2 bg-gray-800 hover:bg-active disabled:bg-gray-800/30') }} @disabled($disabled)>
    {{ $value ?? $slot }}
</button>
