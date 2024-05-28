<div>
    <section class="dashboard-swiper relative overflow-hidden h-[300px] md:h-[600px] lg:h-[840px]"
             x-init="
                $nextTick(() => {
                    new Swiper($el, {
                        modules: [SwiperNavigation, SwiperAutoplay,SwiperParallax],
                        autoplay: { delay: 5000 },
                        loop: true,
                        navigation: {
                            nextEl: $refs['nextBtn'],
                            prevEl: $refs['prevBtn'],
                        },
                        parallax: true,
                    });
                });
             "
    >
        <div class="swiper-wrapper">
            @if($this->carousels)
                @foreach($this->carousels->items->sortBy('sort') as $item)
                    @if($image = $item->getFirstMediaUrl('carousel'))
                        <div class="swiper-slide flex justify-center items-center bg-no-repeat bg-center bg-cover"
                             style="background-image: url({{ $image }})"
                        >
                            <div class="flex justify-center items-center flex-col size-full text-white"
                                 data-swiper-parallax-y="100%"
                                 data-swiper-parallax-opacity="0"
                                 data-swiper-parallax-duration="1250"
                            >
                                <h2 class="mt-4 mb-5 font-normal text-base md:text-2xl lg:text-3xl text-uppercase">{{ $item->texts['sub'] }}</h2>
                                <div
                                    class="mb-12 text-2xl md:text-[50px] lg:text-[80px] leading-7 md:leading-[50px] lg:leading-[85px] font-medium text-uppercase">
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
    </section>

    <section class="categories relative">
        <div class="w-full h-full my-0 lg:-mt-40 static lg:absolute">
            <div class="max-w-screen-2xl relative bg-white mx-auto px-4 z-10">
                <div x-data="{}" class="px-0 py-[70px] lg:px-[185px] lg:py-20 relative">
                    <div class="overflow-hidden relative"
                         x-init="
                            $nextTick(() => {
                                new Swiper($el, {
                                    modules: [SwiperNavigation,SwiperFreeMode],
                                    slidesPerView: 2,
                                    spaceBetween: 80,
                                    breakpoints: {
                                        1024: { slidesPerView: 4 }
                                    },
                                    navigation: {
                                        nextEl: $refs['nextBtn'],
                                        prevEl: $refs['prevBtn'],
                                    },
                                });
                            });
                    ">
                        <div class="swiper-wrapper">
                            @foreach($categories as $category)
                                <div class="swiper-slide">
                                    <a class="flex flex-col justify-between items-center"
                                       href="{{ route('products.index', ['categories[0]' => $category->id]) }}"
                                    >
                                        <img src="{{ $category->image_url }}" />

                                        <span
                                            class="text-nowrap p-0 m-0 md:p-2 md:m-5 font-medium">{{ $category->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <button class="block absolute left-0 md:left-20 lg:left-40 top-1/2" x-ref="prevBtn">
                            <x-heroicon-o-chevron-left class="size-6 text-gray-400" />
                        </button>

                        <button class="block absolute right-0 md:right-20 lg:right-40 top-1/2" x-ref="nextBtn">
                            <x-heroicon-o-chevron-right class="size-6 text-gray-400" />
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="bg-cover bg-no-repeat bg-center"
             style="background-image: url({{ asset('/images/background-9.jpg') }})">
        <div class="text-white max-w-screen-2xl mx-auto py-32 lg:pt-[485px] lg:pb-[215px] px-4">
            <div>
                <h2 class="text-2xl lg:text-6xl font-medium uppercase mb-5">我们的故事</h2>
                <p class="mb-12 text-lg font-normal">产品安全和质量</p>
            </div>

            <div>
                <a href="#"
                   class="inline-flex border-2 border-white border-solid hover:border-active hover:bg-active transition-colors text-base px-10 py-2">
                    更多
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-0 px-4 border-b">
        <div
            class="flex flex-col justify-center items-center md:flex-row mx-auto my-0 max-w-screen-2xl *:text-center *:mx-2 lg:*:mx-8 *:flex-1 *:flex *:items-center *:justify-center *:px-2 *:py-5 md:*:py-16 lg:*:px-12 lg:*:py-32 hover:*:bg-[#f6e6e6] *:transition-colors *:duration-300">
            <div>
                <div class="text-center">
                    <img src="{{ asset('/images/free-shipping-icon-1.png') }}"
                         width="50" height="50"
                         alt="Free Shipping"
                         class="inline-block hover:animate-shake-x"
                    />
                    <h3 class="mt-4 mb-5 font-medium text-base">免运费</h3>
                </div>
            </div>
            <div>
                <div>
                    <img src="{{ asset('/images/money-back-icon-1.png') }}"
                         width="50" height="50"
                         alt="Money Back"
                         class="inline-block"
                    />
                    <h3 class="mt-4 mb-5 font-medium text-base">返现</h3>
                </div>
            </div>
            <div>
                <div>
                    <img src="{{ asset('/images/return-icon-1.png') }}"
                         width="50" height="50"
                         alt="Return"
                         class="inline-block"
                    />
                    <h3 class="mt-4 mb-5 font-medium text-base">售后</h3>
                </div>
            </div>
            <div>
                <div class="text-center">
                    <img src="{{ asset('/images/free-shipping-icon-1.png') }}"
                         width="50" height="50"
                         alt="Free Shipping"
                         class="inline-block"
                    />
                    <h3 class="mt-4 mb-5 font-medium text-base">24/7 在线支持</h3>
                </div>
            </div>
        </div>
    </section>
</div>
