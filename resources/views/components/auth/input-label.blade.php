@props(['value'])

<label {{ $attributes->class('text-[#222] mb-2') }}>
    {{ $value ?? $slot }}
</label>