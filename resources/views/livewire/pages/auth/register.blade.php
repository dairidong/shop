<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.app');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'name' => ['required', 'alpha_dash:ascii', 'max:255', 'unique:' . User::class],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::min(8)->numbers()->letters()],
]);

$register = function () {
    $validated = $this->validate();

    $validated['password'] = Hash::make($validated['password']);

    event(new Registered($user = User::create($validated)));

    Auth::login($user);

    $this->redirect(RouteServiceProvider::HOME, navigate: true);
};

?>
<div class="mt-14 container mx-auto lg:max-w-[1440px] flex flex-col items-center">

    <h2 class="text-center text-xl font-medium my-4">{{ __('Register') }}</h2>

    <div class="w-1/2 border-4 p-6 border-dashed text-sm">
        <form wire:submit="register">
            <!-- Name -->
            <x-auth.form-row>
                <x-auth.input-label for="name">
                    {{ __('Username') }} <span class="text-red-600">*</span>
                </x-auth.input-label>
                <x-auth.text-input
                    id="name"
                    name="name"
                    wire:model="name"
                    type="text"
                    required
                    autofocus
                    autocomplete="name"
                />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />

            </x-auth.form-row>

            <!-- Email Address -->
            <x-auth.form-row>
                <x-auth.input-label for="email">
                    {{ __('Email') }} <span class="text-red-600">*</span>
                </x-auth.input-label>
                <x-auth.text-input wire:model="email" id="email" type="email" name="email" required
                                   autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </x-auth.form-row>

            <!-- Password -->
            <x-auth.form-row>
                <x-auth.input-label for="password">
                    {{ __('Password') }} <span class="text-red-600">*</span>
                </x-auth.input-label>
                <x-auth.text-input wire:model="password" id="password"
                                   type="password"
                                   name="password"
                                   required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </x-auth.form-row>

            <!-- Confirm Password -->
            <x-auth.form-row>
                <x-auth.input-label for="password_confirmation">
                    {{ __('Confirm Password') }} <span class="text-red-600">*</span>
                </x-auth.input-label>

                <x-auth.text-input wire:model="password_confirmation" id="password_confirmation"
                                   class="block mt-1 w-full"
                                   type="password"
                                   name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </x-auth.form-row>

            <x-auth.form-row class="items-center mt-6">
                <div class="w-full flex justify-between items-center flex-col md:flex-row gap-y-6">
                    <div class="hidden md:block"></div>
                    <x-auth.button :value="__('Register')" class="block w-full md:w-max" />
                    <a class="underline text-sm text-gray-600 justify-self-end hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('login') }}" wire:navigate>
                        {{ __('Already registered?') }}
                    </a>
                </div>
            </x-auth.form-row>
        </form>
    </div>
</div>


