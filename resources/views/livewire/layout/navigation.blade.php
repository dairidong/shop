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
                    <x-drawer class="px-0 py-6">
                        <x-slot name="trigger" class="cursor-pointer">
                            <x-hamburger ::data-open="open ? 'true' : 'false'" />
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
                                <li class="hover:bg-gray-100 hover:text-active">
                                    <a class="border-y relative inline-flex w-full h-full p-4 before:block before:content-[''] before:absolute before:bottom-2 before:h-0.5 before:w-0 before:bg-active before:transition-all before:duration-300 before:ease-in-out hover:before:w-12"
                                       href="#">
                                        首页
                                    </a>
                                </li>
                                <li class="hover:bg-gray-100 hover:text-active">
                                    <a class="border-y relative inline-flex w-full h-full p-4 before:block before:content-[''] before:absolute before:bottom-2 before:h-0.5 before:w-0 before:bg-active before:transition-all before:duration-300 before:ease-in-out hover:before:w-12"
                                       href="#">
                                        商城
                                    </a>
                                </li>
                                <li class="hover:bg-gray-100 hover:text-active">
                                    <a class="border-y relative inline-flex w-full h-full p-4 before:block before:content-[''] before:absolute before:bottom-2 before:h-0.5 before:w-0 before:bg-active before:transition-all before:duration-300 before:ease-in-out hover:before:w-12"
                                       href="#">
                                        关于
                                    </a>
                                </li>
                                <li class="hover:bg-gray-100 hover:text-active">
                                    <a class="border-y relative inline-flex w-full h-full p-4 before:block before:content-[''] before:absolute before:bottom-2 before:h-0.5 before:w-0 before:bg-active before:transition-all before:duration-300 before:ease-in-out hover:before:w-12"
                                       href="#">
                                        联系我们
                                    </a>
                                </li>
                            </ul>

                            <div class="p-4 text-base font-bold text-neutral-600 hover:text-active">
                                <a href="#">登录 / 注册</a>
                            </div>
                        </div>
                    </x-drawer>

                </div>
            </div>

            <!-- Logo -->
            <div class="flex grow-0 flex-auto items-center text-center">
                <a href="{{ route('home') }}" wire:navigate>
                    <x-application-logo class="block h-9 w-auto fill-current" />
                </a>
            </div>

            <!-- Tools -->
            <div class="flex flex-1 items-center gap-3 justify-end">
                <button class="tool-search hidden sm:flex cursor-pointer p-1 rounded-full group">
                    <x-heroicon-m-magnifying-glass class="w-7 h-7 group-hover:text-active" />
                </button>

                <a href="#" @click.prevent="" class="tool-wish cursor-pointer p-1 rounded-full group">
                    <x-heroicon-o-heart class="w-7 h-7 group-hover:text-active" />
                </a>

                <div id="tool-user" x-data="{open: false}" @mouseenter="open = true" @mouseleave="open = false"
                     class="tool-user hidden sm:flex cursor-pointer p-1 rounded-full relative group">
                    <x-heroicon-o-user class="w-7 h-7 group-hover:text-active" />

                    <!-- Dropdown menu -->
                    <div x-show="open"
                         x-cloak
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                         class="z-50 absolute bg-white divide-y divide-gray-100 rounded-lg shadow-xl w-44 -translate-x-1/2 left-1/2 top-full"
                    >
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="tool-user">
                            @auth()
                                <li>
                                    <a href="{{ route('profile') }}" wire:navigate
                                       class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">个人中心</a>
                                </li>
                                <li>
                                    <button wire:click="logout"
                                            class="block w-full text-start px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        退出登录
                                    </button>
                                </li>
                            @endauth

                            @guest()
                                <li>
                                    <a href="{{ route('login') }}" wire:navigate
                                       class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ __('Login') }}</a>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>

                <button class="tool-cart cursor-pointer p-1 rounded-full group">
                    <x-heroicon-o-shopping-cart class="w-7 h-7 group-hover:text-active" />
                </button>
            </div>
        </div>
    </div>
</nav>
