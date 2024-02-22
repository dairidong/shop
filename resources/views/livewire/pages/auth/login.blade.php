<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.app');

form(LoginForm::class);

$login = function () {
    $this->validate();

    $this->form->authenticate();

    Session::regenerate();

    $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
};

?>

<div class="mt-14 container mx-auto lg:max-w-[1440px] flex flex-col items-center">
    <!-- Session Status -->
    {{-- todo check styles --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-center text-xl font-medium my-4">{{ __('Login') }}</h2>

    <div class="w-1/2 border-4 p-6 border-dashed text-sm">
        <form wire:submit="login">
            <!-- Email Address -->
            <x-auth.form-row>
                <x-auth.input-label for="username">
                    {{ __('Username Or Email') }} <span class="text-red-600">*</span>
                </x-auth.input-label>
                <x-auth.text-input id="username"
                                   name="username"
                                   wire:model="form.username"
                                   type="text"
                                   required
                                   autofocus
                                   autocomplete="username"
                />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </x-auth.form-row>

            <!-- Password -->
            <x-auth.form-row>
                <x-auth.input-label for="password" class="text-[#222] mb-2">{{ __('Password') }} <span
                        class="text-red-600">*</span></x-auth.input-label>
                <x-auth.text-input id="password"
                                   name="password"
                                   wire:model="form.password"
                                   type="password"
                                   required
                                   autofocus
                                   class="w-full h-10 px-4 border-1 border-[#ccc] focus:border-1 focus:border-[#ccc] focus:ring-0"
                                   autocomplete="current-password"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </x-auth.form-row>

            <x-auth.form-row class="items-center">
                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember" class="inline-flex items-center">
                        <input wire:model="form.remember" id="remember" type="checkbox"
                               class="border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
            </x-auth.form-row>

            <x-auth.form-row class="items-center">
                <x-auth.button type="submit">
                    {{ __('Log in') }}
                </x-auth.button>
            </x-auth.form-row>

            <x-auth.form-row class="items-center">
                <div class="ms-3 flex justify-between gap-6">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="underline text-gray-800 font-bold hover:text-[#a90a0a]"
                           wire:navigate>{{ __('Register') }}</a>
                    @endif

                    @if (Route::has('password.request'))

                        <a class="underline text-sm text-gray-800 hover:text-[#a90a0a] rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                           href="{{ route('password.request') }}" wire:navigate>
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>
            </x-auth.form-row>
        </form>
    </div>

</div>
