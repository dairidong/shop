@props(['value'])

<button {{ $attributes->class('flex items-center justify-center text-white px-14 py-2 bg-gray-800 hover:bg-primary') }}>
    {{ $value ?? $slot }}
</button>