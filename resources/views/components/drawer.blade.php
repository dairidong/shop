@php use Illuminate\Support\Str; @endphp
@props([
    'defaultShow' => false,
    'placement' => 'left',
    'trigger',
    'body'
])

@php
    $bodyClass = match ($placement){
        'right' => "drawer-content fixed top-0 right-0 z-[1000] h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-white w-9/12 md:w-96",
        default => "drawer-content fixed top-0 left-0 z-[1000] h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white w-9/12 md:w-96"
    };
@endphp

<div
        x-data="{
        show: false,
        drawer: null,
        init() {
            this.drawer = new Drawer($el.lastElementChild, {
                placement: '{{ $placement  }}',
                onShow: () => this.show = true,
                onHide: () => this.show = false,
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-[999]'
            });
        },
    }"
        @close="drawer.hide()"
        wire:ignore
        {{ $attributes }}
>
    {{-- Trigger --}}
    <div @click="drawer.toggle();" {{ $trigger->attributes->class("drawer-trigger-wrapper") }}>
        {{ $trigger }}
    </div>

    <!-- drawer component -->
    <div {{ $body->attributes->merge([
                'class' => $bodyClass,
                'tabindex' => '-1',
                'aria-labelledby' => 'drawer-label',
    ]) }}>
        {{ $body ?? $slot }}
    </div>
</div>
