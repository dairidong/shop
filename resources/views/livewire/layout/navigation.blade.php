<?php

use App\Livewire\Actions\Logout;

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<nav class="bg-dark text-white">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center h-20">

            <!-- Hamburger -->
            <div class="flex flex-1">
                <div class="flex items-center">
                    <x-drawer class="p-0 py-6">
                        <x-slot:trigger class="cursor-pointer">
                            <x-hamburger />
                            </x-slot>

                            {{--  Drawer Content  --}}
                            <div class="text-neutral-700">
                                <div class="relative w-full px-6 mb-8">
                                    <input type="search" id="search-dropdown"
                                           class="block p-2.5 w-full z-20 text-sm text-gray-900 bg-gray-50 rounded-md border-2 border-gray-300 focus:border-gray-600 focus:ring-0 focus:shadow-none"
                                           placeholder="Search Product..." required
                                    />
                                    <button type="submit"
                                            class="absolute top-0 end-6 p-2.5 text-sm font-medium h-full text-neutral-600">
                                        <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                             fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                  stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                        <span class="sr-only">Search</span>
                                    </button>
                                </div>

                                <ul class="font-bold text-lg mb-2">
                                    <li class="hover:bg-gray-100">
                                        <a class="border-y inline-flex w-full h-full p-3" href="#">首页</a>
                                    </li>
                                    <li class="hover:bg-gray-100">
                                        <a class="border-y inline-flex w-full h-full p-3" href="#">商城</a>
                                    </li>
                                    <li class="hover:bg-gray-100">
                                        <a class="border-y inline-flex w-full h-full p-3" href="#">关于</a>
                                    </li>
                                    <li class="hover:bg-gray-100">
                                        <a class="border-y inline-flex w-full h-full p-3" href="#">联系我们</a>
                                    </li>
                                </ul>

                                <div class="px-3 text-base font-medium text-neutral-600 hover:text-[#a90a0a]">
                                    <a href="#">登录 / 注册</a>
                                </div>
                            </div>
                    </x-drawer>

                </div>
            </div>

            <!-- Logo -->
            <div class="flex grow-0 flex-auto items-center text-center">
                <a href="{{ route('dashboard') }}" wire:navigate>
                    <x-application-logo class="block h-9 w-auto fill-current" />
                </a>
            </div>

            <!-- Tools -->
            <div class="flex flex-1 items-center gap-3 justify-end">
                <button class="tool-search hidden sm:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>

                <a href="#" @click.prevent="" class="tool-wish">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </a>

                <a href="#" @click.prevent="" class="tool-user hidden sm:flex">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </a>

                <button class="tool-cart">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
