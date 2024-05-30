<?php

?>


<footer class="bg-[#222] text-white">
    <section class="border-b border-[#393939] py-24 px-4">
        <div class="flex flex-wrap gap-y-14 my-0 mx-auto max-w-screen-2xl">
            <div class="w-full md:w-1/2 lg:w-1/3">
                <h3 class="flex items-end gap-x-2 mb-5 lg:mb-10">
                    <x-application-logo class="block h-8 w-auto fill-current" />
                    <span class="font-bold text-xl">{{ config('app.name') }}</span>
                </h3>

                <p class="text-sm mb-4">注意：以下均为虚拟信息，仅做展示。</p>

                <ul class="flex flex-col gap-y-4 text-sm">
                    <li class="flex items-center gap-x-2">
                        <x-heroicon-s-chevron-right class="size-5 text-active" />
                        <span>{{ fake()->address . fake()->streetAddress }}</span>
                    </li>
                    <li class="flex items-center gap-x-2">
                        <x-heroicon-s-chevron-right class="size-5 text-active" />
                        <span>{{ fake()->e164PhoneNumber }}</span>
                    </li>
                    <li class="flex items-center gap-x-2">
                        <x-heroicon-s-chevron-right class="size-5 text-active" />
                        <span>{{ fake()->email }}</span>
                    </li>
                </ul>
            </div>

            <div class="flex flex-col w-full md:w-1/2 lg:w-1/3">
                <h3 class="mb-5 lg:mb-10 text-base font-bold">帐户</h3>

                <ul class="text-sm flex flex-col gap-2">
                    <li><a href="#" class="hover:text-active">关于我们</a></li>
                    <li><a href="#" class="hover:text-active">新闻</a></li>
                    <li><a href="#" class="hover:text-active">企业发展</a></li>
                </ul>
            </div>

            <div class="flex flex-col w-full md:w-1/2 lg:w-1/3">
                <h3 class="mb-5 lg:mb-10 text-base font-bold">帮助</h3>

                <ul class="text-sm flex flex-col gap-2">
                    <li><a href="#" class="hover:text-active">FAQ</a></li>
                    <li><a href="#" class="hover:text-active">退换</a></li>
                    <li><a href="#" class="hover:text-active">联系我们</a></li>
                </ul>
            </div>

        </div>
    </section>

    <section class="py-8 px-4">
        <div class="my-0 mx-auto max-w-screen-2xl">
            <span class="text-sm">Copyright &copy; 2024 jatdung</span>
        </div>
    </section>

</footer>
