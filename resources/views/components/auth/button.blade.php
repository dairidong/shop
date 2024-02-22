@props(['value'])

<button {{ $attributes->class('ms-3 text-white px-14 py-2 bg-gray-800 hover:bg-[#a90a0a]') }}>
    {{ $value ?? $slot }}
</button>