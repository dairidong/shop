<div>
    <div class="dashboard-swiper relative w-screen overflow-hidden h-[300px] sm:h-[600px] md:h-[840px]"
         x-data="{}"
         x-init="
                $nextTick(() => {
                    const swiper = new Swiper($el, {
                        modules: [SwiperNavigation, SwiperAutoplay],
                        autoplay: { delay: 5000 },
                        rewind: true,
                        navigation: {
                            nextEl: $refs['nextBtn'],
                            prevEl: $refs['prevBtn'],
                        }
                    });
                });
             "
    >
        <div class="swiper-wrapper">
            @if($this->carousels)
                @foreach($this->carousels->items as $item)
                    @if($image = $item->getFirstMediaUrl('carousel'))
                        <div class="flex justify-center items-center swiper-slide bg-no-repeat bg-center bg-cover"
                             style="background-image: url({{ $image }})">
                            <div class="flex justify-center items-center flex-col size-full text-white">
                                <h2 class="mt-4 mb-5 font-normal text-3xl text-uppercase">{{ $item->texts['sub'] }}</h2>
                                <div class="mb-12 text-[80px] leading-[85px] font-medium text-uppercase">
                                    {{ $item->texts['main'] }}
                                </div>
                                <div>
                                    <a href="{{ $item->link }}"
                                       class="inline-block border-2 border-white border-solid px-10 text-sm leading-[50px] font-normal text-uppercase cursor-pointer hover:bg-active hover:border-active transition-colors duration-300">
                                        {{ $item->texts['button'] }}
                                    </a>
                                </div>
                            </div>

                        </div>
                    @endif

                @endforeach
            @endif
        </div>

        <div class="hidden md:block">
            <button type="button" x-ref="prevBtn"
                    class="absolute top-1/2 -translate-y-1/2 bg-white size-10 z-10 flex items-center justify-center border left-20">
                <x-heroicon-o-chevron-left class="size-6" />
            </button>
            <button type="button" x-ref="nextBtn"
                    class="absolute top-1/2 -translate-y-1/2 bg-white size-10 z-10 flex items-center justify-center border right-20">
                <x-heroicon-o-chevron-right class="size-6" />
            </button>
        </div>
    </div>
</div>
