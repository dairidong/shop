@php use Illuminate\Support\Str; @endphp
@props([
    'name' => 'drawer-' . Str::random(6),
    'defaultShow' => false,
    'trigger',

])

<div
    x-data="{open: false, drawer: null}"
    x-init="drawer = new Drawer($refs['{{ $name }}'],{onShow: () => open = true, onHide: () => open = false});"
>
    {{-- Trigger --}}
    <div @click="drawer.toggle();" {{ $trigger->attributes->class("drawer-trigger-wrapper") }}>
        {{ $trigger }}
    </div>

    <!-- drawer component -->
    <div {{ $attributes->merge([
                'id' => $name,
                'x-ref' => $name,
                'class' => 'drawer-content fixed top-0 left-0 z-40 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-9/12 md:w-96',
                'tabindex' => '-1',
                'aria-labelledby' => 'drawer-label',
    ]) }}>

        {{ $slot }}
    </div>
</div>