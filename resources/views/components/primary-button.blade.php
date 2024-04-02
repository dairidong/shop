@props(['value'])

<button {{ $attributes->twMerge('flex items-center justify-center text-white px-14 py-2 bg-gray-800 hover:bg-active') }}>
    {{ $value ?? $slot }}
</button>
