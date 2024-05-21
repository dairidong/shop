<div>
    <div class="dashboard-swiper relative w-screen overflow-hidden h-[300px] md:h-[600px] lg:h-[840px]"
         x-data="{ activeIndex: 0 }"
         x-init="
                $nextTick(() => {
                    new Swiper($el, {
                        modules: [SwiperNavigation, SwiperAutoplay],
                        autoplay: { delay: 5000 },
                        rewind: true,
                        navigation: {
                            nextEl: $refs['nextBtn'],
                            prevEl: $refs['prevBtn'],
                        },
                        on: {
                            activeIndexChange: function (swiper) {
                                activeIndex = swiper.activeIndex;
                            }
                        }
                    });
                });
             "
    >
        <div class="swiper-wrapper">
            @if($this->carousels)
                @php $i = 0 @endphp
                @foreach($this->carousels->items as $item)
                    @if($image = $item->getFirstMediaUrl('carousel'))
                        <div class="flex justify-center items-center swiper-slide bg-no-repeat bg-center bg-cover"
                             style="background-image: url({{ $image }})"
                             x-data="{ index: {{ $i++ }} }"
                        >
                            <div class="flex justify-center items-center flex-col size-full text-white"
                                 x-show="index === activeIndex"
                                 x-transition:enter="transition duration-[1250ms]"
                                 x-transition:enter-start="opacity-0 -translate-y-full"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                            >
                                <h2 class="mt-4 mb-5 font-normal text-base md:text-2xl lg:text-3xl text-uppercase">{{ $item->texts['sub'] }}</h2>
                                <div class="mb-12 text-2xl md:text-[50px] lg:text-[80px] leading-7 md:leading-[50px] lg:leading-[85px] font-medium text-uppercase">
                                    {{ $item->texts['main'] }}
                                </div>
                                <div>
                                    <a href="{{ $item->link }}"
                                       class="inline-block border-2 border-white border-solid px-10 text-xs md:text-sm leading-7 md:leading-[50px] font-normal text-uppercase cursor-pointer hover:bg-active hover:border-active transition-colors duration-300">
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
