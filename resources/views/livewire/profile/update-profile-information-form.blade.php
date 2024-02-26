<?php

use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Livewire\Attributes\Validate;
use function Livewire\Volt\computed;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;
use function Livewire\Volt\usesFileUploads;

usesFileUploads();

state([
    'username' => fn() => auth()->user()->username,
    'user_avatar' => fn() => auth()->user()->avatar_url,
]);

state([
    'avatar',
    'name' => auth()->user()->name,
])->attribute(Validate::class);

$avatar_url = computed(function () {
    $user_avatar = auth()->user()->avatar_url;
    $avatar_url = $this->avatar?->temporaryUrl();

    return $avatar_url ?? $user_avatar;
});

rules([
    'avatar' => 'nullable|image|max:1024',
    'name' => 'string|max:255'
]);


$updateProfileInformation = function () {
    $user = Auth::user();

    $validated = $this->validate();

    if ($this->avatar) {
        $avatar_path = $this->avatar->store('avatars', 'public');
        $validated['avatar'] = $avatar_path;
    } else {
        unset($validated['avatar']);
    }

    $user->fill($validated);

    $user->save();

    $this->dispatch('profile-updated', name: $user->name);
};

$sendVerification = function () {
    $user = Auth::user();

    if ($user->hasVerifiedEmail()) {
        $this->redirectIntended(default: RouteServiceProvider::HOME);

        return;
    }

    $user->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};

?>

<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation"
          class="flex flex-col gap-y-6 mt-6"
          x-data="{uploading: false}"
          x-on:livewire-upload-start="uploading = true"
          x-on:livewire-upload-finish="uploading = false"
          x-on:livewire-upload-cancel="uploading = false"
          x-on:livewire-upload-error="uploading = false"
    >

        <x-form-row>
            <div class="flex items-center gap-6">
                <x-input-label class="block text-base mb-0" :value="__('Avatar')" />
                <label for="avatar" class="relative block size-20 cursor-pointer rounded-full group">
                    <img class="absolute size-full z-10 block rounded-full object-center object-cover"
                         src="{{ $this->avatar_url }}" alt="Preview avatar">
                    <span wire:loading.class="!hidden"
                          wire:target="avatar"
                          class="absolute items-center justify-center size-full z-20 rounded-full bg-black/30 hidden">
                        <x-heroicon-s-arrow-up-tray class="size-8 text-white" />
                    </span>
                    <span wire:loading.flex
                          wire:target="avatar"
                          class="absolute items-center justify-center size-full z-20 rounded-full bg-black/30">
                        <x-icons.spinner />
                    </span>
                </label>
            </div>

            <input wire:model="avatar" id="avatar" name="avatar" type="file" class="hidden" wire:target="avatar" wire:loading.attr="disabled">
            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
        </x-form-row>

        <x-form-row>
            <x-input-label for="name" class="text-base" :value="__('Username')" />
            <x-text-input disabled id="username" type="text" class="mt-1 block w-full bg-gray-100" :value="$username" />
        </x-form-row>

        <x-form-row>
            <x-input-label for="name" class="text-base" :value="__('NickName')" />
            <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full"
                          autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </x-form-row>

        {{--<div>--}}
        {{--    <x-input-label for="email" :value="__('Email')" />--}}
        {{--    <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />--}}
        {{--    <x-input-error class="mt-2" :messages="$errors->get('email')" />--}}

        {{--    @if (auth()->user() instanceof MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())--}}
        {{--        <div>--}}
        {{--            <p class="text-sm mt-2 text-gray-800">--}}
        {{--                {{ __('Your email address is unverified.') }}--}}

        {{--                <button wire:click.prevent="sendVerification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">--}}
        {{--                    {{ __('Click here to re-send the verification email.') }}--}}
        {{--                </button>--}}
        {{--            </p>--}}

        {{--            @if (session('status') === 'verification-link-sent')--}}
        {{--                <p class="mt-2 font-medium text-sm text-green-600">--}}
        {{--                    {{ __('A new verification link has been sent to your email address.') }}--}}
        {{--                </p>--}}
        {{--            @endif--}}
        {{--        </div>--}}
        {{--    @endif--}}
        {{--</div>--}}

        <div class="flex items-center gap-4 mt-4">
            <x-primary-button ::disabled="uploading"
                              ::class="uploading ? 'cursor-not-allowed !bg-gray-500' :''"
                              class="px-6"
                              type="submit">
                <span x-show="!uploading" :class="{'hidden': uploading}">{{ __('Save') }}</span>
                <span x-show="uploading">{{ __('Uploading') }}</span>
            </x-primary-button>

            <x-action-message class="me-3" on="profile-updated">
                {{ __('Saved.') }}
            </x-action-message>
        </div>
    </form>
</section>
