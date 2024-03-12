@props([
    'src',
    'iconSize' => 16
])

<img
    x-data="{
        shown: false,
        src: @js($src)
    }"
    x-intersect.once="shown = true"
    :src="shown ? src : ''"
    {{ $attributes }}
/>
