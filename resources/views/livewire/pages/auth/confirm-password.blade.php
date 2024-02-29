<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.app');

state(['password' => '']);

rules(['password' => ['required', 'string']]);

$confirmPassword = function () {
    $this->validate();

    if (!Auth::guard('web')->validate([
        'email' => Auth::user()->email,
        'password' => $this->password,
    ])) {
        throw ValidationException::withMessages([
            'password' => __('auth.password'),
        ]);
    }

    session(['auth.password_confirmed_at' => time()]);

    $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
};

?>

<div class="flex flex-col sm:justify-center items-center pt-6 sm:pt-0 mt-20 sm:mt-60">
    <div>
        <a href="/" wire:navigate>
            <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
        </a>
    </div>

    <div class="w-full max-w-sm sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden">
        <div>
            <div class="mb-4 text-sm text-gray-600">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form wire:submit="confirmPassword">
                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input wire:model="password"
                                  id="password"
                                  class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-6">
                    <x-primary-button class="px-8" wire:loading.class="bg-gray-300 hover:bg-gray-300 cursor-not-allowed">
                        <x-icons.spinner wire:loading class="me-2" :size="5" />
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>