@props(['images'])

<div
    x-data="{
        images: @js($images),
        selected: 0,
        carousel: null
    }"
    class="flex flex-col-reverse md:flex-row gap-4 w-full lg:w-1/2"
    x-init="
        $nextTick(() => {
            const carouselElements = $el.querySelectorAll('[x-carousel-item]');
            const items = Array.prototype.map.call(carouselElements, (el, index) => ({
                position: index,
                el,
            }));

            carousel = new Carousel($el, items);

            carousel.updateOnChange(function (){
                selected = carousel.getActiveItem().position;
            })
        });
    "
    wire:ignore
    {{ $attributes->except(['x-data', 'class', 'x-init', 'wire:ignore']) }}
>
    <ul class="flex flex-row md:flex-col gap-2">
        <template x-for="(image, index) in images">
            <li class="size-12 bg-[#f3f3f3] flex items-center cursor-pointer"
                :class="selected === index ? 'border border-gray-800' : ''"
                :aria-current="selected === index"
                :aria-label="`Slide ${index + 1}`"
                :x-carousel-slide-to="index"
                @click="carousel.slideTo(index)"
            >
                <img :src="image.thumb"/>
            </li>
        </template>
    </ul>

    <div class="relative w-full md:w-11/12 h-[600px] overflow-hidden">
        <div
            x-data="{ touchStartX: null }"
            @touchstart.passive="touchStartX = $event.targetTouches[0].clientX"
            @touchend.passive="
                const moveX = touchStartX - $event.changedTouches[0].clientX;
                if(moveX > 0) {
                    carousel.next();
                } else if (moveX < 0) {
                    carousel.prev();
                }
                touchStartX = null
            "
        >
            <template x-for="(image, index) in images">
                <div class="hidden duration-700 ease-in-out" x-carousel-item>
                    <div class="h-full flex items-center bg-black">
                        <img :src="image.origin"/>
                    </div>
                </div>
            </template>
        </div>

        <button
            class="absolute left-2 top-1/2 flex justify-center items-center size-14 rounded-full bg-white z-50 border -translate-y-1/2"
            @click.stop="carousel.prev()"
        >
            <x-heroicon-o-chevron-left class="size-8 text-gray-800"/>
        </button>

        <button
            class="absolute right-2 top-1/2 flex justify-center items-center size-14 rounded-full bg-white z-50 border -translate-y-1/2"
            @click.stop="carousel.next()"
        >
            <x-heroicon-o-chevron-right class="size-8 text-gray-800"/>
        </button>
    </div>
</div>
