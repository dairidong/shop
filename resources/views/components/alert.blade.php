@props([
    'message',
    'icon' => 'heroicon-o-information-circle'
])

@if(isset($message) || isset($slot))
    <div {{ $attributes->class('w-full bg-active text-white px-8 py-4 text-sm flex items-center') }}>
        @if($icon)
            @svg($icon, 'size-6 me-2')
        @endif
        {{ $message ?? $slot }}
    </div>
@endif


